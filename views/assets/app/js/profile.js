const form = document.querySelector('#profile-form');
const toast = document.querySelector('#toast');

readValuesInputs();

form.addEventListener('submit', async (event) => {

    event.preventDefault();

    const token = localStorage.getItem('token');

    const formData = new FormData(form);

    try {

        const response = await fetch('http://localhost/atelie/api/users/update',
            {
                method: 'PUT',
                headers: { 'token': token},
                body: formData
            }
        );

        const data = await response.json();

        if (!response.ok) {
            toast.innerHTML = data.message;
        }

        toast.innerHTML = 'Dados atualizados com sucesso.';

    } catch (error) {

        console.error(error);
        toast.innerHTML = 'Erro de conexão com a api';

    }

});

function readValuesInputs() {
    const inputName = document.querySelector('#name');
    const inputEmail = document.querySelector('#email');

    const lsNameUser = localStorage.getItem('userName');
    console.log(lsNameUser);
}