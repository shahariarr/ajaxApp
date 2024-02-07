@extends('layout')
@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add User
    </button> <br><br><br>

    <!-- createModal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">user Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  id="save-form">

                        <input type="text" id="name" class="form-control" placeholder="Enter your name">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal-close">Close</button>
                    <button type="button" class="btn btn-primary"  onclick="Save()" id="save-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

  {{-- edit modal --}}
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">user Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  id="update-form">

                        <input type="text" id="updatename" class="form-control" placeholder="Enter your name">
                        <input class="d-none" id="updateID"/>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="Update-modal-close">Close</button>
                    <button type="button" class="btn btn-primary" onclick="Update()" id="update-btn">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- delete modal --}}

    <div class="modal animated zoomIn" id="delete-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 class=" mt-3 text-warning">Delete !</h3>
                    <p class="mb-3">Once delete, you can't get it back.</p>
                    <input class="d-none" id="deleteID"/>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" id="delete-modal-close" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn btn-danger" >Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <table class="table" id="tableData">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody id="tableList">


        </tbody>
    </table>
@endsection
@push('scripts')
    <script>



        $(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '1000',
				'hideDuration': '1000',
				'timeOut': '1000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		});

                getList();
                async function getList() {
                    try {

                        let res = await axios.get('/user');



                        let tableList = document.getElementById('tableList');
                        let tableData=$("#tableData");

                        tableData.DataTable().destroy();
                        $('#tableList').empty();

                        res.data.data.forEach(function(item, index){
                            let tr = `<tr>
                            <td>${ index+1}</td>
                            <td>${item.name}</td>

                            <td><button class="btn edit btn-primary" data-id="${item['id']}" >Edit</button></td>

                            <td><button class="btn delete btn-danger" data-id="${item['id']}" data-bs-toggle="modal">Delete</button></td>

                            </tr>`;
                            tableList.innerHTML += tr;
                        });


                            $('.edit').on('click',function(){
                                let id=$(this).data('id');

                                $('#EditModal').modal('show');
                                $('#updateID').val(id);

                               FillUpUpdateForm(id);

                            })

                            $('.delete').on('click',function(){
                                let id=$(this).data('id');
                                $('#delete-modal').modal('show');
                                $('#deleteID').val(id);

                            })

                            new DataTable('#tableData',{
                             order:[[0,'asc']],
                             lengthMenu:[5,10,15,20,30]
                             });



                    } catch (error) {
                        console.log(error);


                    }
                }

       async function Save() {
        try {
            let name = document.getElementById('name').value;
            document.getElementById('modal-close').click();


            let res = await axios.post("/user",{name:name})

            console.log(res);


            if(res.data['status']==="success"){

                document.getElementById("save-form").reset();


                await getList();
                toastr.success(res.data['message'], 'success')
            }
            else{
                toastr.error(res.data['message'], 'Error')
            }

        }catch (error) {
            console.log(error);
        }
    }

    async function itemDelete(){
        try{
            let id=$('#deleteID').val();
            document.getElementById('delete-modal-close').click();
            let res=await axios.post('/userdelete',{id:id})
            console.log(res);
            if(res.data['status']==="success"){
                toastr.success(res.data['message'], 'Delete success')
                await getList();

            }
            else{
                toastr.error(res.data['message'], 'Error')
            }


        }
        catch(error){
            console.log(error);
        }
    }


    async function FillUpUpdateForm(id){
       try {

           $('#updateID').val(id);

           let res=await axios.post("/user-by-id",{id:id})
          // console.log(res.data.rows.name);

           document.getElementById('updatename').value=res.data.rows.name;
       }
       catch (error) {
              console.log(error);
        }
    }


    async function Update()
    {
        try {
            let id = document.getElementById('updateID').value;
            let name = document.getElementById('updatename').value;
            document.getElementById('Update-modal-close').click();
            let res = await axios.post("/update-user",{id:id,name:name})

            if(res.data['status']==="success"){
                document.getElementById("update-form").reset();
                toastr.success(res.data['message'], 'success')

                await getList();

            }
            else{
                toastr.error(res.data['message'], 'Error')
            }
        }


            catch (error) {
              console.log(error);
        }
    }












    </script>
@endpush
