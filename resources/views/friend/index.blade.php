@extends('layouts.cp')

@section('title','Arkadaşların')

@section('SearchBar')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="row SearchBar">
                <div class="col-md-4" ></div>
                <div class="col-md-8" >
                    <a class="btn btn-success" style="float:right;min-width:75px;" id="" href="{{ route('friends.create') }}">Ekle</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-bordered data-table" id="myTable" name="myTable">
        <thead>
        <th>#</th>
        <th>Adı</th>
        <th>Telefon Numarası</th>
        <th>Araçlar</th>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="modal modal-danger" id="DeleteModal" style="margin-top:300px;" name="DeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="text-align:center;">
                    <p style="font-size:20px;"> Arkadaşı Silmek İstediğinizden Emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <form id="DeletionForm" method="post" action="">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Onayla</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal Et</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function deleteRecord(id){
            var DeletionForm = document.getElementById("DeletionForm");
            var url = "{{route('friends.destroy', '')}}"+"/"+id;
            DeletionForm.action = url;
        }

        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('friends.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'telephone',
                        name: 'telephone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
@endpush
