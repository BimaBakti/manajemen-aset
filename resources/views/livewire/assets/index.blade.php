<?php

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, with};

new class extends Component {
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $locationFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedLocationFilter(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'assets' => Asset::query()
                ->with(['category', 'location', 'assignedUser'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('asset_tag', 'like', '%' . $this->search . '%')
                          ->orWhere('serial_number', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->categoryFilter, function ($query) {
                    $query->where('category_id', $this->categoryFilter);
                })
                ->when($this->statusFilter, function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->when($this->locationFilter, function ($query) {
                    $query->where('location_id', $this->locationFilter);
                })
                ->latest()
                ->paginate(10),
            'categories' => Category::where('is_active', true)->get(),
            'locations' => Location::where('is_active', true)->get(),
        ];
    }
}; ?>

<x-layouts.app>
    <flux:main>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="xl">Assets</flux:heading>
                    <flux:text variant="subdued">Manage your company assets</flux:text>
                </div>
                
                <flux:button icon="plus" href="/assets/create" wire:navigate variant="primary">
                    Add Asset
                </flux:button>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search assets..."
                    icon="magnifying-glass"
                />
                
                <flux:select wire:model.live="categoryFilter" placeholder="All Categories">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="statusFilter" placeholder="All Status">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="in_use">In Use</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="retired">Retired</option>
                    <option value="lost">Lost</option>
                </flux:select>

                <flux:select wire:model.live="locationFilter" placeholder="All Locations">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Assets Table -->
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                @if($assets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Asset</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Assigned To</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($assets as $asset)
                                    <tr wire:key="asset-{{ $asset->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $asset->name }}</div>
                                                <div class="text-sm text-zinc-500">{{ $asset->asset_tag }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $asset->category->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $asset->location->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <flux:badge :variant="$asset->status_color" size="sm">
                                                {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                                            </flux:badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $asset->assignedUser->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <flux:button size="sm" variant="ghost" href="/assets/{{ $asset->id }}" wire:navigate>
                                                    View
                                                </flux:button>
                                                <flux:button size="sm" variant="ghost" href="/assets/{{ $asset->id }}/edit" wire:navigate>
                                                    Edit
                                                </flux:button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <flux:icon name="computer-desktop" class="mx-auto h-12 w-12 text-zinc-400" />
                        <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">No assets found</h3>
                        <p class="mt-1 text-sm text-zinc-500">Get started by adding your first asset.</p>
                        <div class="mt-6">
                            <flux:button href="/assets/create" wire:navigate variant="primary">
                                Add Asset
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($assets->hasPages())
                <div class="flex justify-center">
                    {{ $assets->links() }}
                </div>
            @endif
        </div>
    </flux:main>
</x-layouts.app>
