const main = document.querySelector('main');

function createPopUp(action) {
    const popUpExists = document.getElementById('popUp');

    if (popUpExists) {
        if (popUpExists.classList.contains('action_' + action)) {
            deletePopUp();
            return;
        } else {
            deletePopUp();
        }
    }

    const popUp = document.createElement('div');
    popUp.id = 'popUp';
    popUp.classList.add(
        'border-1', 'border-white', 'rounded-lg', 'fixed', 'top-1/2', 'left-1/2',
        'transform', '-translate-x-1/2', '-translate-y-1/2', 'bg-black',
        'bg-opacity-75', 'flex', 'items-center', 'justify-center', 'z-50',
        'action_' + action
    );

    if (action === 'login_form' || action === 'register_form') {
        console.log('Creating pop-up for action:', action);
        const isLogin = action === 'login_form';
        popUp.innerHTML = `
        <div class="p-6 w-96">
            <h2 class="text-xl font-bold mb-4">${isLogin ? 'Login' : 'Register'}</h2>
            <form action="${isLogin ? '/MyInsta/process/login.php' : '/MyInsta/process/register.php'}" method="POST" class="flex flex-col items-center gap-4" id="${action}">
                <div class="w-full">
                    <label class="block mb-2">Username</label>
                    <input type="text" name="username" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="w-full">
                    <label class="block mb-2">Password</label>
                    <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                ${isLogin ? '' : `
                <div class="w-full">
                    <label class="block mb-2">Confirm Password</label>
                    <input type="password" name="confirm_password" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                `}
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">${isLogin ? 'Login' : 'Register'}</button>
                <button onclick="createPopUp('${isLogin ? 'register_form' : 'login_form'}')" class="text-blue-400 underline">
                    ${isLogin ? 'Create an account' : 'Already have an account ?'}
                </button>
                <button onclick="deletePopUp()" class="self-end text-red-500">Close</button>
            </form>
        </div>`;
    }

    else if (action === 'add_photo_form') {
        popUp.innerHTML = `
        <div class="p-6 w-96">
            <h2 class="text-xl font-bold mb-4">Add Photo</h2>
            <form action="/MyInsta/process/add_photo.php" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-4" id="${action}">
                <div class="w-full">
                    <label class="block mb-2">Select Photo</label>
                    <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="w-full">
                    <label class="block mb-2">Description</label>
                    <input type="text" name="description" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded">Upload Photo</button>
                <button onclick="deletePopUp()" class="self-end text-red-500">Close</button>
            </form>
        </div>`;
    }

    main.appendChild(popUp);
}

function deletePopUp() {
    const popUp = document.getElementById('popUp');
    if (popUp) popUp.remove();
}
