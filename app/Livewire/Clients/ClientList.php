<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use \WW\Countries\Models\Country;

class ClientList extends DataTableComponent
{
    use LivewireAlert;
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
        'user.email' => null,
    ];

    public function configure(): void
    {
        $this->setBulkActionsStatus(false);
        $this->setLoadingPlaceholderEnabled();
        $this->setLoadingPlaceHolderIconAttributes([
            'class' => 'lds-spinner',
            'default' => false,
        ]);
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['clients.id as id'])
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
            Column::make('Name', 'client_name')
                ->sortable()
                ->searchable(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'user.email')
                ->sortable()
                ->searchable(),
            Column::make('Contract started', 'contract_start_date')
                ->sortable(),
            Column::make('Contract end', 'contract_end_date')
                ->sortable(),
            Column::make('Industry', 'industry.name')
                ->sortable()
                ->searchable(),
            Column::make('Street Address','street_address')
                ->sortable()
                ->searchable(),
            Column::make('City', 'city')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')
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
            ->when($this->columnSearch['client_name'] ?? null, fn ($query, $client_name) => $query->where('client.client_name', 'like', '%' . $client_name . '%'));
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
        $clients = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new ClientsExport($clients), 'clients.xlsx');
    }

    public function activate()
    {
        Client::whereIn('id', $this->getSelected())->update(['status' => 'active']);

        $this->clearSelected();
    }

    public function deactivate()
    {
        Client::whereIn('id', $this->getSelected())->update(['status' => 'suspended']);
        $this->clearSelected();
    }

    public function deleteItem($id)
    {
        Client::where('id', $id)->delete();
        $this->alert('success', 'Client successifuly deleted',[
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
            'width' => '600',
           ]);
    }

    public function viewItem($id)
    {
        return redirect()->to('/view-client'.$id);
    }

    public function editItem($id)
    {
        return redirect()->to('/update-client/'.$id);
    }
}