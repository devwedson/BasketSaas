@extends('layouts.attex.app')

@section('title', 'Comissão Técnica')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Comissão Técnica',
    'subtitle' => 'Técnicos, auxiliares e equipe multidisciplinar',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Comissão']],
    'actionUrl' => route('staff.create'),
    'actionLabel' => 'Novo Membro',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista da Comissão</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $staffMembers->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Profissional</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Função</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($staffMembers as $member)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ staff_photo_url($member) }}" alt="{{ $member->name }}" class="h-9 w-9 rounded-full object-cover border border-gray-100 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $member->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $member->role->label() }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $member->team?->name ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap">@include('partials.attex.status-badge', ['active' => $member->is_active])</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('staff.show', $member),
                                    'editUrl' => route('staff.edit', $member),
                                    'deleteUrl' => route('staff.destroy', $member),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('partials.attex.empty-row', ['colspan' => 5])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials.attex.pagination', ['paginator' => $staffMembers])
@endsection