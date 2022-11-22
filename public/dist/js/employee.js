
const employeeModal = document.querySelector('#employee-add-modal');
const employeeUpdateModal = document.querySelector('#employee-update-modal')
let updateModal;
let updateId;
async function employeeAdd(event){
    event.preventDefault();
     const form = new FormData(event.target);
     const result = await fetch('/employee', {
         method: "POST",
         headers: {
             "X-CSRF-Token": form.get('_token'),
         },
         credentials: "same-origin",
         body: form,
     });
     const modal = bootstrap.Modal.getInstance(employeeModal)
     if(result.status==200){
         console.log(modal)
         toastr.success(await result.json());
         dataTable.ajax.reload();
         event.target.reset();
         modal.hide();
     }else if(result.status==422){
         const errors = await result.json();
         Object.entries(errors.errors).forEach(([key, value]) => {
             toastr.error(value);
         });
     }else{
         toastr.error('Beklenmeyen bir hata oluştu adminle iletişime geçiniz.');
     }
 
 }

 function updateModalEmployee(element,id){
    employeeUpdateModal.querySelector('input[name="name"]').value = element.closest('tr').children[1].innerHTML;
    employeeUpdateModal.querySelector('select').value = element.closest('tr').children[2].children[0].getAttribute('id');
    updateModal = new bootstrap.Modal(employeeUpdateModal, {});
    updateId = id;
    updateModal.show();
}

async function updateEmployee(event){
    event.preventDefault();
    const form = new FormData(event.target);
    const result = await fetch(`/employee/${updateId}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": form.get('_token'),
            'Content-Type':'application/json'
        },
        credentials: "same-origin",
        body: JSON.stringify({name:form.get('name'),company_id:form.get('company_id')}) ,
    });
    
    if(result.status==200){
        toastr.success(await result.json());
        dataTable.ajax.reload();
        event.target.reset();
        updateModal.hide();
    }else if(result.status==422){
        const errors = await result.json();
        Object.entries(errors.errors).forEach(([key, value]) => {
            toastr.error(value);
        });
    }else{
        toastr.error('Beklenmeyen bir hata oluştu adminle iletişime geçiniz.');
    }
}

function deleteEmployee(id){
    Swal.fire({
        title: "Bu kullanıcıyı silme talebi oluşturuyorsunuz.",
        text: "Bu kullanıcıyı silme talebi oluşturmak istediğinizden emin misiniz ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Evet",
        cancelButtonText: "Hayır",
    }).then( async (result) => {
        if (result.isConfirmed) {
            const result = await fetch(`/employee/${id}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                
            });
        
            if (result.status == 422) {
                const errors = await result.json();
                Object.entries(errors.errors).forEach(([key, value]) => {
                    toastr.error(value);
                });
            }
            if (result.status == 200) {
                toastr.success(await result.json());
                dataTable.ajax.reload();
            }

        }
    });
    
}