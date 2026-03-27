<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Properties extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public string $filterStatus = '';
    public string $filterCity = '';
    public string $filterType = '';

    // CRUD state
    public bool $showModal = false;
    public bool $showViewModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;
    public ?int $viewingId = null;
    public ?int $deletingId = null;

    // Multi-step wizard
    public int $currentStep = 1;
    public int $totalSteps = 5;

    // Step 1: Property Type
    public string $title = '';
    public string $property_type_id = '';
    public bool $status = true;

    // Step 2: Location
    public string $city_id = '';
    public string $address = '';

    // Step 3: Photos
    public array $photos = [];
    public array $existingPhotos = [];

    // Step 4: Property Details
    public string $description = '';
    public string $bedrooms = '';
    public string $bathrooms = '';
    public string $area = '';
    public string $amenities = '';

    // Step 5: Price
    public string $price = '';

    protected function stepRules(): array
    {
        return match ($this->currentStep) {
            1 => [
                'title' => 'required|string|max:255',
                'property_type_id' => 'required|exists:property_types,id',
                'status' => 'boolean',
            ],
            2 => [
                'city_id' => 'required|exists:cities,id',
                'address' => 'required|string|max:255',
            ],
            3 => $this->editingId
                ? ['photos.*' => 'nullable|image|max:5120']
                : ['photos' => 'nullable|array', 'photos.*' => 'nullable|image|max:5120'],
            4 => [
                'description' => 'required|string',
                'bedrooms' => 'required|integer|min:0',
                'bathrooms' => 'required|integer|min:0',
                'area' => 'required|integer|min:1',
                'amenities' => 'nullable|string',
            ],
            5 => [
                'price' => 'required|numeric|min:0',
            ],
            default => [],
        };
    }

    protected function allRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'status' => 'boolean',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterStatus', 'filterCity', 'filterType']);
        $this->resetPage();
    }

    public function goToStep(int $step): void
    {
        // Allow navigating back freely, but validate before going forward
        if ($step > $this->currentStep) {
            $this->validate($this->stepRules());
        }
        $this->currentStep = $step;
    }

    public function nextStep(): void
    {
        $this->validate($this->stepRules());
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function removePhoto(int $index): void
    {
        array_splice($this->photos, $index, 1);
    }

    public function removeExistingPhoto(int $id): void
    {
        $this->existingPhotos = array_values(array_filter($this->existingPhotos, fn ($p) => $p['id'] !== $id));
    }

    public function create(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->currentStep = 1;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $property = Property::with('images')->findOrFail($id);
        $this->editingId = $id;
        $this->currentStep = 1;
        $this->title = $property->title;
        $this->property_type_id = (string) $property->property_type_id;
        $this->status = (bool) $property->status;
        $this->city_id = (string) $property->city_id;
        $this->address = $property->address;
        $this->description = $property->description;
        $this->bedrooms = (string) $property->bedrooms;
        $this->bathrooms = (string) $property->bathrooms;
        $this->area = (string) $property->area;
        $this->amenities = $property->amenities ?? '';
        $this->price = (string) $property->price;
        $this->photos = [];
        $this->existingPhotos = $property->images->map(fn ($img) => [
            'id' => $img->id,
            'path' => $img->image_path,
        ])->toArray();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate($this->allRules());

        $data = [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'property_type_id' => $this->property_type_id,
            'status' => $this->status,
            'city_id' => $this->city_id,
            'address' => $this->address,
            'description' => $this->description,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'area' => $this->area,
            'amenities' => $this->amenities ?: '',
            'price' => $this->price,
        ];

        if ($this->editingId) {
            $property = Property::findOrFail($this->editingId);
            $property->update($data);

            // Remove deleted existing photos
            $keepIds = collect($this->existingPhotos)->pluck('id')->toArray();
            $property->images()->whereNotIn('id', $keepIds)->each(function ($img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
                $img->delete();
            });

            $position = count($keepIds);
            session()->flash('success', 'Property updated successfully.');
        } else {
            $property = Property::create($data);
            $position = 0;
            session()->flash('success', 'Property created successfully.');
        }

        // Save new uploaded photos
        foreach ($this->photos as $photo) {
            $path = $photo->store('properties', 'public');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'position' => $position++,
            ]);
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function view(int $id): void
    {
        $this->viewingId = $id;
        $this->showViewModal = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            $property = Property::with('images')->findOrFail($this->deletingId);
            foreach ($property->images as $img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
            }
            $property->delete();
            session()->flash('success', 'Property deleted successfully.');
        }
        $this->showDeleteModal = false;
        $this->deletingId = null;
    }

    public function export(): StreamedResponse
    {
        $properties = $this->buildQuery()->get();

        return response()->streamDownload(function () use ($properties) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Price', 'Address', 'Bedrooms', 'Bathrooms', 'Area', 'City', 'Status', 'Created']);

            foreach ($properties as $property) {
                fputcsv($handle, [
                    $property->id,
                    $property->title,
                    $property->price,
                    $property->address,
                    $property->bedrooms,
                    $property->bathrooms,
                    $property->area,
                    $property->city?->name ?? '',
                    $property->status ? 'Active' : 'Inactive',
                    $property->created_at->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        }, 'properties-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportExcel(): StreamedResponse
    {
        $properties = $this->buildQuery()->get();

        return response()->streamDownload(function () use ($properties) {
            $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
            $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"';
            $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            $xml .= '<Worksheet ss:Name="Properties"><Table>' . "\n";

            $xml .= '<Row>';
            foreach (['ID', 'Title', 'Price', 'Address', 'Bedrooms', 'Bathrooms', 'Area', 'City', 'Status', 'Created'] as $header) {
                $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($header, ENT_XML1) . '</Data></Cell>';
            }
            $xml .= '</Row>' . "\n";

            foreach ($properties as $property) {
                $xml .= '<Row>';
                $xml .= '<Cell><Data ss:Type="Number">' . $property->id . '</Data></Cell>';
                foreach ([
                    $property->title,
                    $property->price,
                    $property->address,
                    $property->bedrooms,
                    $property->bathrooms,
                    $property->area,
                    $property->city?->name ?? '',
                    $property->status ? 'Active' : 'Inactive',
                    $property->created_at->format('Y-m-d'),
                ] as $value) {
                    $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars((string) $value, ENT_XML1) . '</Data></Cell>';
                }
                $xml .= '</Row>' . "\n";
            }

            $xml .= '</Table></Worksheet></Workbook>';
            echo $xml;
        }, 'properties-' . now()->format('Y-m-d') . '.xls', [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['title', 'description', 'price', 'address', 'bedrooms', 'bathrooms', 'area', 'amenities', 'property_type_id', 'city_id', 'editingId', 'photos', 'existingPhotos', 'currentStep']);
        $this->status = true;
        $this->currentStep = 1;
        $this->resetValidation();
    }

    private function buildQuery()
    {
        return Property::query()
            ->with(['city', 'propertyType'])
            ->when($this->search, fn ($q) => $q->where(fn ($sq) => $sq
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('address', 'like', "%{$this->search}%")))
            ->when($this->filterStatus !== '', fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterCity, fn ($q) => $q->where('city_id', $this->filterCity))
            ->when($this->filterType, fn ($q) => $q->where('property_type_id', $this->filterType))
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function render()
    {
        $properties = $this->buildQuery()->paginate($this->perPage);

        $activeFilterCount = collect([$this->filterStatus !== '' ? $this->filterStatus : null, $this->filterCity, $this->filterType])
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->count();

        $cities = City::orderBy('name')->get();
        $propertyTypes = PropertyType::all();
        $viewProperty = $this->viewingId ? Property::with(['city', 'propertyType', 'user'])->find($this->viewingId) : null;

        return view('livewire.admin.properties', compact('properties', 'activeFilterCount', 'cities', 'propertyTypes', 'viewProperty'))
            ->layout('components.layouts.admin')
            ->title('Properties');
    }
}
