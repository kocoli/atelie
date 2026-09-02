const form = document.querySelector('#formLogin');
const toast = document.querySelector('#toast');

form.addEventListener('submit', async (e)=>{
 
    e.preventDefault();

    try {

        const response = await fetch(
            
            'http://localhost/atelie/api/users/login-admin',

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
            window.location.href = 'http://localhost/atelie/views/admin/dashboard.php';

        } else {
            toast.innerHTML = data.message;
        }
       
    } catch (error) {
        console.error(error);
        toast.innerHTML = 'Erro de conexão com a api';
    }


});