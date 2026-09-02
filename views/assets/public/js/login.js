const form = document.querySelector('#formLogin');
const toast = document.querySelector('#toast');

form.addEventListener('submit', async (e)=>{
 
    e.preventDefault();

    try {

        const response = await fetch( 'http://localhost/atelie/api/users/login',

            {
                method: 'POST',
                body: new FormData(form)
            }
        );

        const user = await response.json();

        if (!response.ok) {
           toast.innerHTML = user.message;
           return; 
        }
        

        localStorage.setItem('token', user.data.token);
        localStorage.setItem('userId', user.data.id);
        localStorage.setItem('userName', user.data.name);
        localStorage.setItem('userEmail', user.data.email);
        localStorage.setItem('userPhoto', user.data.photo);
        
        form.reset();
        toast.innerHTML = "";
        window.location.href = 'http://localhost/atelie/views/app/dashboard.html';
       
    } catch (error) {
        console.error(error);
        toast.innerHTML = 'Erro de conexão com a api';
    }

});