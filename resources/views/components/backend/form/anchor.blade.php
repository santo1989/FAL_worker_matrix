@props(['href', 'type'])

@php
    switch ($type) {
        case 'create':
            $buttonClass = 'btn btn-lg btn-outline-secondary';
            $iconClass = 'bi bi-plus-circle';
            break;
        case 'edit':
            $buttonClass = 'btn btn-sm btn-outline-success';
            $iconClass = 'bi bi-pencil-square';
            break;
        case 'delete':
            $buttonClass = 'btn btn-sm btn-outline-danger';
            $iconClass = 'bi bi-trash';
            break;
        case 'show':
            $buttonClass = 'btn btn-sm btn-outline-info';
            $iconClass = 'bi bi-eye';
            break;
        case 'Download':
            $buttonClass = 'btn btn-sm btn-outline-primary';
            $iconClass = 'bi bi-download';
            break;
        case 'PrintPage':
            $buttonClass = 'btn btn-sm btn-outline-dark';
            $iconClass = 'bi bi-printer';
            break;
        default:
            $buttonClass = 'btn btn-sm btn-outline-warning';
            $iconClass = 'bi bi-save';
            break;
    }
@endphp

<a href="{{ $href }}" class="btn {{ $buttonClass }}">
    <span class="{{ $iconClass }} me-1"></span>
    {{ $type }}
</a>
