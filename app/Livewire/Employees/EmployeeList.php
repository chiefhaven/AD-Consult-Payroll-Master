<?php

namespace App\Livewire\Employees;

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


class EmployeeList extends DataTableComponent
{
    public $myParam = 'Default';
    public string $tableName = 'employee';
    public $employee = Employee::class;
    public $email = '';

    public function customView(): string
    {
        return 'includes.custom';
    }

    public $columnSearch = [
        'fname' => null,
        'sname' => null,
        'user.email' => null,
    ];

    public function configure(): void
    {
        $this->setDefaultSort('created_at', 'desc');
        $this->setBulkActionsStatus(false);
        $this->setLoadingPlaceholderEnabled();
        $this->setLoadingPlaceHolderIconAttributes([
            'class' => 'lds-spinner',
            'default' => false,
        ]);
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['employees.id as id'])
            ->setConfigurableAreas([
              'toolbar-left-middle' => ['includes.areas.toolbar-left-start', ['param1' => $this->myParam]]
             ])
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
            Column::make('Firstname', 'fname')
                ->sortable()
                ->searchable(),
            Column::make('Maidenname', 'mname')
                ->sortable()
                ->searchable(),
            Column::make('Sirname', 'sname')
                ->sortable()
                ->searchable(),
            Column::make('Company/Organization', 'client.client_name')
                ->sortable()
                ->searchable(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),
            Column::make('Email Address', 'user.email')
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),
            Column::make('Status', 'status')
                ->sortable(),
            Column::make('Created at', 'created_at')
            ->sortable(),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('tables.action-column')->with(
                        [
                            'employee' => $row,
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
        Employee::whereIn('id', $this->getSelected())->update(['status' => 'active']);

        $this->clearSelected();
    }

    public function deactivate()
    {
        Employee::whereIn('id', $this->getSelected())->update(['status' => 'suspended']);

        $this->clearSelected();
    }

    public function deleteItem()
    {
        Employee::where('id', 56)->delete();
    }

    // public function reorder($items): void
    // {
    //     foreach ($items as $item) {
    //         Employee::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
    //     }
    // }
}
