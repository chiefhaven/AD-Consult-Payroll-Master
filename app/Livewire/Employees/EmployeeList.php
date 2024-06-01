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
use Jantinnerezo\LivewireAlert\LivewireAlert;


class EmployeeList extends DataTableComponent
{
    use LivewireAlert;
    public $myParam = 'Default';
    public int $client_id;
    public string $tableName = 'employee';
    public $employee;
    public $email = '';

    public function mount(){
        $this->employee = Employee::where('client_id', 1)->get();
    }

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
            ->setHideBulkActionsWhenEmptyEnabled();
        }

    public function columns(): array
    {
        return [
            Column::make('Firstname', 'fname')
                ->sortable()
                ->searchable(),
            Column::make('Othernames', 'mname')
                ->sortable()
                ->searchable(),
            Column::make('Lastname', 'sname')
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
                            'resource' => $row,
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
                    'Active' => 'Active',
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

    public function deleteItem($id)
    {
        Employee::where('id', $id)->delete();
        $this->alert('success', 'Employee successifuly deleted',[
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
            'width' => '600',
           ]);
    }

    public function editItem($id)
    {
        return redirect()->to('/update-employee/'.$id);
    }
}
