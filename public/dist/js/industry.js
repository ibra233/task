const industryModal = document.querySelector('#industry-add-modal');
const industryUpdateModal = document.querySelector('#industry-update-modal')
let updateModal;
let updateId;
const lang = document.querySelector('html').getAttribute('lang');
const notification = {
tr:{
    unexpectedError:'Beklenmeyen bir hata oluştu adminle iletişime geçiniz.',
    swalTitle:'Bu endüstriyi siliyorsunuz !',
    swalText: 'Bu endüstriyi silmek istediğinize emin misiniz ?',
    swalConfirm: 'Evet',
    swalCancel: 'Hayır',
},
en:{
    unexpectedError:'Contact your name for an unexpected error occurred.',
    swalTitle:'You are erasing this industry !',
    swalText:'Are you sure you want to delete this industry?',
    swalConfirm: 'Yes',
    swalCancel: 'No',
}
}
    


async function industryAdd(event){
   event.preventDefault();
    const form = new FormData(event.target);
    const result = await fetch('/industry', {
        method: "POST",
        headers: {
            "X-CSRF-Token": form.get('_token'),
        },
        credentials: "same-origin",
        body: form,
    });
    const modal = bootstrap.Modal.getInstance(industryModal)
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

function deleteIndustry (id){
    Swal.fire({
        title: notification[lang].swalTitle,
        text: notification[lang].swalText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: notification[lang].swalConfirm,
        cancelButtonText: notification[lang].swalCancel,
    }).then( async (result) => {
        if (result.isConfirmed) {
            const result = await fetch(`/industry/${id}`, {
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

function updateModalIndustry(element,id){
    industryUpdateModal.querySelector('input[name="name"]').value = element.closest('tr').children[1].innerHTML;
    updateModal = new bootstrap.Modal(industryUpdateModal, {});
    updateId = id;
    updateModal.show();
}

async function updateIndustry(event){
    event.preventDefault();
    const form = new FormData(event.target);
    const name = {name:'a'};
    const result = await fetch(`/industry/${updateId}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": form.get('_token'),
            'Content-Type':'application/json'
        },
        credentials: "same-origin",
        body: JSON.stringify({name:form.get('name')}) ,
    });
    
    console.log(form.getAll('name'));
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