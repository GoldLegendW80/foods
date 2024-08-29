@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-dark text-light position-relative">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="mb-0 text-accent">Catégories</h1>
        </div>
        <div class="col-auto">
            <button id="add-category-btn" class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus-circle me-2"></i>Ajouter une catégorie
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-accent btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une catégorie -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-accent" id="addCategoryModalLabel">Ajouter une catégorie</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control bg-secondary text-light border-dark" id="name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addCategoryForm" class="btn btn-accent">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier une catégorie -->
@foreach($categories as $category)
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-accent" id="editCategoryModalLabel{{ $category->id }}">Modifier {{ $category->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm{{ $category->id }}" action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name{{ $category->id }}" class="form-label">Nom</label>
                        <input type="text" class="form-control bg-secondary text-light border-dark" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="editCategoryForm{{ $category->id }}" class="btn btn-accent">Modifier</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('styles')
<style>
    .table {
        margin-bottom: 0;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endpush