<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\BooleanColumn;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\ImageColumn;
use RamonRietdijk\LivewireTables\Columns\SelectColumn;
use RamonRietdijk\LivewireTables\Filters\BooleanFilter;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Filters\SelectFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;


class EmployeeList extends LivewireTable
{
    protected string $model = Employee::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Firstname'), 'fname')
                ->sortable(),

            SelectColumn::make(__('Sirname'), 'sname')
                ->sortable(),

            Column::make(__('Company'), 'client_id')
                ->sortable(),

                Column::make(__('Phone'), 'phone')
                    ->sortable(),

            // BooleanColumn::make(__('Email address'), 'published')
            //     ->sortable(),
            Column::make(__('Email address'), 'user.email')
                ->sortable(),

            DateColumn::make(__('Hired on'), 'hiredate')
                ->sortable()
                ->format('F jS, Y'),

            Column::make(__('Actions'), function (Model $model): string {
                return '<a class="underline" href="#'.$model->getKey().'">Edit</a>';
            })
                ->clickable(false)
                ->asHtml(),
        ];
    }

    protected function filters(): array
    {
        return [
            BooleanFilter::make(__('Published'), 'published'),

            SelectFilter::make(__('Category'), 'category_id')
                ->options(
                    // Category::query()->get()->pluck('title', 'id')->toArray()
                ),

            SelectFilter::make(__('Author'), 'author_id')
                ->options(
                    User::query()->get()->pluck('name', 'id')->toArray()
                ),

            DateFilter::make(__('Created At'), 'created_at'),
        ];
    }

    protected function actions(): array
    {
        return [
            Action::make(__('Publish All'), 'publish_all', function (): void {
                Blog::query()->update(['published' => true]);
            })->standalone(),

            Action::make(__('Publish'), 'publish', function (Enumerable $models): void {
                $models->each(function (Blog $user): void {
                    $user->published = true;
                    $user->save();
                });
            }),

            Action::make(__('Unpublish'), 'unpublish', function (Enumerable $models): void {
                $models->each(function (Blog $user): void {
                    $user->published = false;
                    $user->save();
                });
            }),
        ];
    }
}
