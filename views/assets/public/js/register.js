const form = document.querySelector('#formRegister');
const inputPass = document.querySelector('#inputPass')
const confirmPass = document.querySelector('#confirmPass')
const toast = document.querySelector('#toast');

form.addEventListener('submit', async (e)=>{
 
    e.preventDefault();

    if (inputPass.value !== confirmPass.value) {
        toast.innerHTML = 'Confire sua senha';
        return;
    }

    try {

        const response = await fetch(
            
            'http://localhost/atelie/api/users/register',

            {
                method: 'POST',
                body: new FormData(form)
            }
        );

        const data = await response.json();
        console.log(data);

        if (response.ok) {
            form.reset();
            toast.innerHTML = "";
            toast.innerHTML = data.message;

        } else {
            toast.innerHTML = data.message;
        }
       
    } catch (error) {
        console.error(error);
        toast.innerHTML = 'Erro de conexão com a api';
    }


});