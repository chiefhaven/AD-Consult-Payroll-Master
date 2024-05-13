<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use App\Exports\UsersExport;
use Carbon\Carbon;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Button;
use Maatwebsite\Excel\Facades\Excel;

class ClientList extends DataTableComponent
{
    public $myParam = 'Default';
    public string $tableName = 'client';
    public $client = Client::class;
    public $email = '';

    public function customView(): string
    {
        return 'includes.custom';
    }

    public $columnSearch = [
        'client_name' => null,
    ];

    public function configure(): void
    {
        $this->setLoadingPlaceholderEnabled();
        $this->setLoadingPlaceHolderIconAttributes([
            'class' => 'lds-spinner',
            'default' => false,
        ]);
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['clients.id as id'])
            // ->setConfigurableAreas([
            //     'toolbar-left-start' => ['includes.areas.toolbar-left-start', ['param1' => $this->myParam]]
            // ])
            ->setSecondaryHeaderTrAttributes(function($rows) {
                return ['class' => 'bg-primary'];
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-red-500'];
                }
                return ['default' => true];
            })
            ->setHideBulkActionsWhenEmptyEnabled()
            // ->setTableRowUrl(function($row) {
            //     return '/employee-details/'.$row->id;
            // })
            // ->setTableRowUrlTarget(function($row) {
            //     return '_blank';
            // });
            ;
        }

    public function columns(): array
    {
        return [
            // ImageColumn::make('Avatar')
            //     ->location(function($row) {
            //         return asset('img/logo-'.$row->id.'.png');
            //     })
            //     ->attributes(function($row) {
            //         return [
            //             'class' => 'w-8 h-8 rounded-full',
            //         ];
            //     }),
            Column::make('Name', 'client_name')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Email', 'user.email')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Industry', 'industry_id')
                ->sortable()
                ->searchable(),
            Column::make('Address','address')
                ->sortable()
                ->searchable(),
            Column::make('City', 'city')
                ->sortable()
                ->searchable(),
            Column::make('Country', 'country_id')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')
                ->sortable(),
            // Column::make('Tags')
            //     ->label(fn($row) => $row->tags->pluck('name')->implode(', ')),
            // // Column::make('Actions')
            //     ->label(
            //         fn($row, Column $column) => view('tables.cells.actions')->withUser($row)
            //     )
            //     ->unclickable(),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('tables.action-column')->with(
                        [
                            'client' => $row,
                        ]
                    )
                )->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->setFilterPillTitle('Active')
                ->options([
                    ''    => 'Any',
                    'active' => 'Active',
                    'suspended'  => 'Suspended',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'active') {
                        $builder->whereNotNull('status');
                    } elseif ($value === 'suspended') {
                        $builder->whereNull('status');
                    }
                }),
            DateFilter::make('Joined From')
                ->config([
                    'max' => Carbon::now()->toDateString(),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('start_date', '>=', $value);
                }),
            DateFilter::make('Joined To')
                ->config([
                    'max' => Carbon::now()->toDateString(),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('start_date', '<=', $value);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Client::query()
            ->when($this->columnSearch['client_name'] ?? null, fn ($query, $fname) => $query->where('client.client_name', 'like', '%' . $fname . '%'));
    }

    public function bulkActions(): array
    {
        return [
            'activate' => 'Activate',
            'deactivate' => 'Deactivate',
            'export' => 'Export',
        ];
    }

    public function export()
    {
        $employees = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new UsersExport($employees), 'employees.xlsx');
    }

    public function activate()
    {
        Employee::whereIn('id', $this->getSelected())->update(['status' => 'active']);

        $this->clearSelected();
    }

    public function deactivate()
    {
        Employee::whereIn('id', $this->getSelected())->update(['status' => 'suspended']);

        $this->clearSelected();
    }

    // public function reorder($items): void
    // {
    //     foreach ($items as $item) {
    //         Employee::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
    //     }
    // }
}
