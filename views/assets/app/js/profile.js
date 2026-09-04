const form = document.querySelector('#profile-form');
const toast = document.querySelector('#toast');

const inputName = document.querySelector('#name');
const inputEmail = document.querySelector('#email');
const imgAvatar = document.querySelector('#img-avatar');

const lsNameUser = localStorage.getItem('userName');
const lsEmailUser = localStorage.getItem('userEmail');
const lsPhotoUser = localStorage.getItem('userPhoto');

const token = localStorage.getItem('token');

renderInput();

form.addEventListener('submit', async (event) => {

    event.preventDefault();

    const urlencoded = new URLSearchParams();

    urlencoded.append('name', inputName.value);
    urlencoded.append('email', inputEmail.value);

    try {

        const response = await fetch(
            'http://localhost/atelie/api/users/update',
            {
                method: 'PUT',

                headers: {
                    'token': token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },

                body: urlencoded
            }
        );

        const result = await response.json();


        if (!response.ok) {
            toast.textContent = result.message;
            return;
        }

        inputName.value = result.data.name;
        inputEmail.value = result.data.email;

        localStorage.setItem('userName', result.data.name);
        localStorage.setItem('userEmail', result.data.email);

        toast.textContent = 'Dados atualizados com sucesso.';

    } catch (error) {

        console.error(error);
        toast.textContent = 'Erro de conexão com a API';

    }
});

function renderInput() {

    inputName.value = lsNameUser ?? '';
    inputEmail.value = lsEmailUser ?? '';

    if (!lsPhotoUser || lsPhotoUser === 'null') {

        imgAvatar.src = '../assets/common/img/avatar-default.png';

    } else {

        imgAvatar.src = `../assets/common/img/${lsPhotoUser}`;

    }
}