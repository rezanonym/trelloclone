<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Trello Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-image: url('https://placehold.co/1920x1080?text=Background+Image+of+Desert+at+Night');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .drag-over {
            border: 2px dashed #4A90E2;
        }
    </style>
</head>
<body class="text-white">
    <div class="bg-gray-900 bg-opacity-80 p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <i class="fab fa-trello text-2xl"></i>
            <span class="text-xl font-semibold">Trello</span>
            <nav class="flex space-x-4">
                <a class="hover:underline" href="#">Workspaces</a>
                <a class="hover:underline" href="#">Recent</a>
                <a class="hover:underline" href="#">Starred</a>
                <a class="hover:underline" href="#">Templates</a>
            </nav>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
    </div>
    <div class="bg-gray-800 bg-opacity-80 p-2 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <button class="bg-gray-700 hover:bg-gray-600 text-white py-1 px-2 rounded">a</button>
            <i class="fas fa-star"></i>
            <span class="font-semibold">Board</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="flex items-center space-x-4">
            <i class="fas fa-search"></i>
            <i class="fas fa-bell"></i>
            <div class="relative">
                <img alt="User Avatar" class="rounded-full" height="30" src="https://storage.googleapis.com/a1aa/image/cJuAWlTSy9ogOFGmIislfnhqkoF4M1aTuOIyFTNVANVMynyJA.jpg" width="30"/>
                <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full px-1">2</span>
            </div>
            <div class="relative">
                <i class="fas fa-share cursor-pointer" onclick="toggleShareMenu()"></i>
                <div id="share-menu" class="absolute right-0 mt-2 w-64 bg-gray-700 text-white rounded-lg shadow-lg p-4 hidden">
                    <input type="email" id="share-email" class="w-full p-2 rounded bg-gray-600 text-white" placeholder="Enter email address"/>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mt-2 w-full" onclick="shareBoard()">SHARE</button>
                </div>
            </div>
            <div class="relative">
                <button class="bg-gray-700 hover:bg-gray-600 text-white py-1 px-2 rounded" onclick="toggleUserInfo()">YP</button>
                <div id="user-info" class="absolute right-0 mt-2 w-64 bg-gray-700 text-white rounded-lg shadow-lg p-4 hidden">
                    <p><strong>User Information</strong></p>
                    <p>Name: Your Name</p>
                    <p>Email: your.email@example.com</p>
                    <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded mt-2 w-full" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </div>
    <div id="board" class="p-4 flex space-x-4 overflow-x-auto">
        <div class="list bg-black bg-opacity-80 rounded-lg p-4 w-64">
            <div class="flex justify-between items-center mb-4">
                <input type="text" class="list-title bg-transparent border-none text-white font-semibold" value="do" onfocus="clearPlaceholder(this)" onblur="saveTitle(this)" onkeydown="handleKeyDown(event, this)"/>
                <div class="flex space-x-2">
                    <i class="fas fa-arrows-alt"></i>
                    <i class="fas fa-ellipsis-h"></i>
                </div>
            </div>
            <div class="cards" ondragover="allowDrop(event)" ondrop="drop(event, this)"></div>
            <button class="add-card bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded w-full">+ Add a card</button>
        </div>
        <button id="add-list" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded w-64">+ Add another list</button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.add-card').forEach(button => {
                button.addEventListener('click', addCard);
            });

            document.getElementById('add-list').addEventListener('click', addList);
        });

        function addCard(event) {
            const button = event.target;
            const cardsContainer = button.previousElementSibling;
            const card = document.createElement('div');
            card.className = 'bg-gray-600 text-white p-2 rounded mb-2 flex justify-between items-center';
            card.innerHTML = `
                <input type="text" class="card-title bg-transparent border-none text-white w-full" value="New Card" onfocus="clearPlaceholder(this)" onblur="saveTitle(this)" onkeydown="handleCardKeyDown(event, this)"/>
                <i class="fas fa-pencil-alt cursor-pointer ml-2" onclick="editCard(this)"></i>
                <i class="fas fa-arrow-right cursor-pointer ml-2 hidden" onclick="moveCard(this)"></i>
                <button class="save-button hidden bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded ml-2" onclick="saveCard(this)">Save</button>
            `;
            cardsContainer.appendChild(card);
            const cardTitleInput = card.querySelector('.card-title');
            cardTitleInput.focus();
            cardTitleInput.setSelectionRange(0, cardTitleInput.value.length);
        }

        function addList() {
            const board = document.getElementById('board');
            const newList = document.createElement('div');
            newList.className = 'list bg-black bg-opacity-80 rounded-lg p-4 w-64';
            newList.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <input type="text" class="list-title bg-transparent border-none text-white font-semibold" value="New List" onfocus="clearPlaceholder(this)" onblur="saveTitle(this)" onkeydown="handleKeyDown(event, this)"/>
                    <div class="flex space-x-2">
                        <i class="fas fa-arrows-alt"></i>
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                </div>
                <div class="cards" ondragover="allowDrop(event)" ondrop="drop(event, this)"></div>
                <button class="add-card bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded w-full">+ Add a card</button>
            `;
            board.insertBefore(newList, document.getElementById('add-list'));

            newList.querySelector('.add-card').addEventListener('click', addCard);
            const listTitleInput = newList.querySelector('.list-title');
            listTitleInput.focus();
            listTitleInput.setSelectionRange(0, listTitleInput.value.length);
        }

        function clearPlaceholder(input) {
            if (input.value === 'New List' || input.value === 'New Card') {
                input.value = '';
            }
        }

        function saveTitle(input) {
            if (input.value.trim() === '') {
                input.value = input.classList.contains('list-title') ? 'New List' : 'New Card';
            }
        }

        function handleKeyDown(event, input) {
            if (event.key === 'Enter') {
                input.blur();
            }
        }

        function handleCardKeyDown(event, input) {
            if (event.key === 'Enter') {
                addCard({ target: input.closest('.list').querySelector('.add-card') });
            }
        }

        function editCard(pencilIcon) {
            const card = pencilIcon.closest('.flex');
            const cardTitleInput = card.querySelector('.card-title');
            const saveButton = card.querySelector('.save-button');
            const moveIcon = card.querySelector('.fa-arrow-right');
            cardTitleInput.removeAttribute('readonly');
            cardTitleInput.focus();
            cardTitleInput.setSelectionRange(0, cardTitleInput.value.length);
            saveButton.classList.remove('hidden');
            moveIcon.classList.remove('hidden');
        }

        function saveCard(saveButton) {
            const card = saveButton.closest('.flex');
            const cardTitleInput = card.querySelector('.card-title');
            cardTitleInput.setAttribute('readonly', true);
            saveButton.classList.add('hidden');
            card.querySelector('.fa-arrow-right').classList.add('hidden');
        }

        function moveCard(arrowIcon) {
            const card = arrowIcon.closest('.flex');
            const currentList = card.closest('.list');
            const nextList = currentList.nextElementSibling;
            if (nextList && nextList.classList.contains('list')) {
                nextList.querySelector('.cards').appendChild(card);
            }
        }

        function toggleShareMenu() {
            const shareMenu = document.getElementById('share-menu');
            shareMenu.classList.toggle('hidden');
        }

        function shareBoard() {
            const email = document.getElementById('share-email').value;
            if (email) {
                alert(`Board shared with ${email}`);
                document.getElementById('share-email').value = '';
                toggleShareMenu();
            } else {
                alert('Please enter an email address');
            }
        }

        function toggleUserInfo() {
            const userInfo = document.getElementById('user-info');
            userInfo.classList.toggle('hidden');
        }

        function logout() {
            alert('Logged out');
            // Add your logout logic here
        }

        function allowDrop(event) {
            event.preventDefault();
            event.currentTarget.classList.add('drag-over');
        }

        function drop(event, target) {
            event.preventDefault();
            event.currentTarget.classList.remove('drag-over');
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                const card = document.createElement('div');
                card.className = 'bg-gray-600 text-white p-2 rounded mb-2 flex justify-between items-center';
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        card.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" class="w-full h-auto rounded"/>
                        `;
                        target.appendChild(card);
                    };
                    reader.readAsDataURL(file);
                } else {
                    card.innerHTML = `
                        <span>${file.name}</span>
                        <i class="fas fa-paperclip ml-2"></i>
                    `;
                    target.appendChild(card);
                }
            }
        }
    </script>
</body>
</html>
