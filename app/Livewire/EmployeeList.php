<?php

namespace App\Livewire;

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
use Maatwebsite\Excel\Facades\Excel;


class EmployeeList extends DataTableComponent
{

    public $myParam = 'Default';
    public string $tableName = 'employee';
    public $employee = Employee::class;

    public function customView(): string
    {
        return 'includes.custom';
    }

    public $columnSearch = [
        'fname' => null,
        'sname' => null,
    ];

    public function configure(): void
    {
        $this->setLoadingPlaceholderEnabled();
        $this->setPrimaryKey('id')
            ->setDebugDisabled()
            ->setAdditionalSelects(['id as id'])
            ->setConfigurableAreas([
                'toolbar-left-start' => ['includes.areas.toolbar-left-start', ['param1' => $this->myParam]]
            ])
            ->setSecondaryHeaderTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-red-500'];
                }
                return ['default' => true];
            })
            ->setFooterTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setFooterTdAttributes(function(Column $column, $rows) {
                if ($column->isField('fname')) {
                    return ['class' => 'text-green-500'];
                }

                return ['default' => true];
            })
            ->setHideBulkActionsWhenEmptyEnabled()
            ->setTableRowUrl(function($row) {
                return '/employee-details/'.$row->id;
            })
            ->setTableRowUrlTarget(function($row) {
                return '_blank';
            });
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
            Column::make('Firstname', 'fname')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Maidenname', 'mname')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Sirname', 'sname')
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Company', 'client_id')
                ->sortable()
                ->searchable(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),
            Column::make('Email Address', 'current_address')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make('Status', 'status')
                ->sortable(),
            // Column::make('Tags')
            //     ->label(fn($row) => $row->tags->pluck('name')->implode(', ')),
            // // Column::make('Actions')
            //     ->label(
            //         fn($row, Column $column) => view('tables.cells.actions')->withUser($row)
            //     )
            //     ->unclickable(),
            ButtonGroupColumn::make('Actions')
                ->unclickable()
                ->attributes(function($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('My Link 1')
                        ->title(fn($row) => 'Link 1')
                        ->location(fn($row) => 'https://'.$row->id.'google1.com')
                        ->attributes(function($row) {
                            return [
                                'target' => '_blank',
                                'class' => 'underline text-blue-500',
                            ];
                        }),
                    LinkColumn::make('My Link 2')
                        ->title(fn($row) => 'Link 2')
                        ->location(fn($row) => 'https://'.$row->id.'google2.com')
                        ->attributes(function($row) {
                            return [
                                'class' => 'underline text-blue-500',
                            ];
                        }),
                    LinkColumn::make('My Link 3')
                        ->title(fn($row) => 'Link 3')
                        ->location(fn($row) => 'https://'.$row->id.'google3.com')
                        ->attributes(function($row) {
                            return [
                                'class' => 'underline text-blue-500',
                            ];
                        })
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            // TextFilter::make('Firstname')
            //     ->filter(function(Builder $builder, string $value) {
            //         $builder->where('employee.fname', 'like', '%'.$value.'%');
            //     }),
            // MultiSelectFilter::make('Tags')
            //     ->options(
            //         Tag::query()
            //             ->orderBy('name')
            //             ->get()
            //             ->keyBy('id')
            //             ->map(fn($tag) => $tag->name)
            //             ->toArray()
            //     )->filter(function(Builder $builder, array $values) {
            //         $builder->whereHas('tags', fn($query) => $query->whereIn('tags.id', $values));
            //      }),
                // ->setFilterPillValues([
                //     '3' => 'Tag 1',
                // ]),
            SelectFilter::make('Status', 'status')
                ->setFilterPillTitle('Active')
                ->options([
                    ''    => 'Any',
                    'active' => 'Active',
                    'probation'  => 'Probation',
                    'onLeave'  => 'On Leave',
                    'suspended'  => 'Suspended',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'active') {
                        $builder->whereNotNull('status');
                    } elseif ($value === 'suspended') {
                        $builder->whereNull('status');
                    }
                }),
            DateFilter::make('Hired From')
                ->config([
                    'max' => Carbon::now()->toDateString(),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('hiredate', '>=', $value);
                }),
            DateFilter::make('Hired To')
                ->config([
                    'max' => Carbon::now()->toDateString(),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('hiredate', '<=', $value);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Employee::query()
            ->when($this->columnSearch['fname'] ?? null, fn ($query, $fname) => $query->where('employee.fname', 'like', '%' . $fname . '%'))
            ->when($this->columnSearch['sname'] ?? null, fn ($query, $sname) => $query->where('employee.sname', 'like', '%' . $sname . '%'));
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
        Employee::whereIn('id', $this->getSelected())->update(['active' => true]);

        $this->clearSelected();
    }

    public function deactivate()
    {
        Employee::whereIn('id', $this->getSelected())->update(['active' => false]);

        $this->clearSelected();
    }

    // public function reorder($items): void
    // {
    //     foreach ($items as $item) {
    //         Employee::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
    //     }
    // }
}
