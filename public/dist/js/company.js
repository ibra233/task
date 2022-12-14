const companyAddModal = document.querySelector('#company-add-modal');
const cancelIndustryHtml = `<div class="col d-flex align-items-center">
                <a href='#'  class="text-dark mt-4" onclick="industryCancelButton(this)" > <i class="fas fa-times"></i></a>
              </div>`;

const changehtmk = document.querySelector("#industries").cloneNode(true);
const companyUpdateModal = document.querySelector('#company-update-modal')
let updateModal;
let updateId;
const lang = document.querySelector('html').getAttribute('lang');
const notification = {
tr:{
    unexpectedError:'Beklenmeyen bir hata oluştu adminle iletişime geçiniz.',
    swalIndustryTitle:'Bu şirketin endüstrisini siliyorsunuz !',
    swalIndustryText: 'Bu şirketin endüstrisini silmek istediğinize emin misiniz ?',
    swalTitle:'Bu şirketi siliyorsunuz !',
    swalText: 'Bu şirketi silmek istediğinize emin misiniz ?',
    swalConfirm: 'Evet',
    swalCancel: 'Hayır',
},
en:{
    unexpectedError:'Contact your name for an unexpected error occurred.',
    swalIndustryTitle:'You are erasing this industry of company !',
    swalIndustryText:'Are you sure you want to delete this industry of company?',
    swalTitle:'You are erasing this company !',
    swalText: 'Are you sure you want to delete this company ?',
    swalConfirm: 'Yes',
    swalCancel: 'No',
}
}
changehtmk.insertAdjacentHTML("beforeend", cancelIndustryHtml);

function addIndustrySelectBox(element) {
    element.insertAdjacentHTML("beforebegin", changehtmk.outerHTML);
}

function industryCancelButton(element){
    element.parentElement.parentElement.remove()
}

async function companyAdd(event){
    event.preventDefault();
     const form = new FormData(event.target);
     const result = await fetch('/company', {
         method: "POST",
         headers: {
             "X-CSRF-Token": form.get('_token'),
         },
         credentials: "same-origin",
         body: form,
     });
     const modal = bootstrap.Modal.getInstance(companyAddModal)
     if(result.status==200){
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

 function updateModalCompany(element,data){
    updateModal = new bootstrap.Modal(companyUpdateModal, {});
    updateId = data;
    updateModal.show();
    
    companyUpdateModal.querySelector('input[name="name"]').value = element.closest('tr').children[1].innerHTML;

    const html = [...element.parentElement.previousElementSibling.children].reduce((total,element)=> {
    return  total+=`<div class="d-inline-flex align-items-center p-2 bg-info text-white mb-2 mx-2"> <div >${element.innerHTML}</div> <div class="ms-2">
    <a href=""  onclick="deleteIndustryOfCompany(event,${element.getAttribute('id')})"><i class="fas fa-trash ml-2 text-white"></i></a></div> </div>`},`<p class="form-label">Şirket Endüstrileri</p>`)
    document.querySelector('#company-industries').innerHTML = html;
 }

async function updateCompany(event){
    event.preventDefault();
    const form = new FormData(event.target);
 
    const result = await fetch(`/company/update/${updateId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": form.get('_token'),
        },
        credentials: "same-origin",
        body: form ,
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

function deleteIndustryOfCompany(event,id){
    event.preventDefault();
    Swal.fire({
        title: notification[lang].swalIndustryText,
        text: notification[lang].swalIndustryText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: notification[lang].swalConfirm,
        cancelButtonText: notification[lang].swalCancel,
    }).then( async (result) => {
        if (result.isConfirmed) {
            const result = await fetch(`/industryOfCompany/${updateId}/${id}`, {
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
                event.target.closest('.d-inline-flex').remove();
                dataTable.ajax.reload();
            }

        }
    });
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
            const result = await fetch(`/company/${id}`, {
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