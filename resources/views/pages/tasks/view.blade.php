@extends('layout.app')
@section('content')
@viteReactRefresh
@vite('resources/js/pages/Task.jsx')
<style>
    .yoopta-editor {
        width: 100% !important;
        padding: 20px;
    }
    .btn.btn-primary.mt-4{
        display: none;
    }
</style>
<div class="container">
    <div id="app"></div>
</div>
@endsection

@section('js_footer')
@endsection
