const form = document.querySelector("#form");

const toBase64 = async file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const successMessage = document.querySelector(".success-message");
    const errorsMessage = document.querySelector("#errors");

    successMessage.style.display = "none";
    errorsMessage.style.display = "none";

    const formData = new FormData(e.target);
    const data = Array.from(formData.entries()).reduce((memo, [key, value]) => ({
        ...memo,
        [key]: value,
    }), {});

    data.image = await toBase64(data.image);
    const json = JSON.stringify(data);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:8000/api/post");
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = () => {
        if (xhr.status === 201 && xhr.readyState === 4) {
            successMessage.style.display = "block";
            form.reset();
            getPostsList();
        }

        if (xhr.status === 400 && xhr.readyState === 4) {
            const parsed = JSON.parse(xhr.response);
            errorsMessage.innerText = parsed.errors;
            errorsMessage.style.display = "block";
        }
    }
    xhr.send(json);
});

const getPostsList = (page = 1) => {

    const list = document.querySelector("#posts-list tbody");
    list.innerHTML = '';

    const req = new XMLHttpRequest();

    req.open('GET', `http://localhost:8000/api/post?pageNumber=${page}`, false);
    req.send(null);
    if(req.status === 404) {
        const row = document.createElement('tr');
        const element = document.createElement('td');
        const parsed = JSON.parse(req.response);
        element.colSpan = 4;
        element.innerText = parsed.errors;
        row.appendChild(element);
        list.appendChild(row);
    }
    if(req.status === 200 && req.readyState === 4) {
        const parsedRequest = JSON.parse(req.response)

        parsedRequest.data.forEach(item => {
            const row = document.createElement('tr');

            for (const [key, value] of Object.entries(item)) {
                const element = document.createElement('td');

                if (key === 'image') {
                    const image = document.createElement('img');
                    image.src = value;
                    element.appendChild(image);
                } else {
                    element.innerHTML = value;
                }

                row.appendChild(element);
            }
            list.appendChild(row);
        });

        const paginator = document.querySelector("#paginator");
        paginator.innerHTML = '';

        for (let i = 1; i <= parsedRequest.paginator.totalPages; i++) {
            const button = document.createElement('button');
            button.innerText = i;

            button.onclick = () => getPostsList(i);
            button.disabled = i === parsedRequest.paginator.pageNumber;

            paginator.appendChild(button);
        }
    }
}

getPostsList();
