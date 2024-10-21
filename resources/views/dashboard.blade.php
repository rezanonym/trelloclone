<html>
 <head>
  <title>
   Trello Clone
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #d9d9d9;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #1c1c1c;
        }
        .header .logo {
            display: flex;
            align-items: center;
        }
        .header .logo img {
            height: 24px;
            margin-right: 10px;
        }
        .header .nav {
            display: flex;
            align-items: center;
        }
        .header .nav a {
            color: #d9d9d9;
            text-decoration: none;
            margin: 0 10px;
        }
        .header .nav a:hover {
            text-decoration: underline;
        }
        .header .search {
            display: flex;
            align-items: center;
        }
        .header .search input {
            padding: 5px;
            border: none;
            border-radius: 3px;
        }
        .header .search i {
            margin-left: 10px;
            cursor: pointer;
        }
        .sidebar {
            width: 250px;
            background-color: #1c1c1c;
            padding: 20px;
            position: fixed;
            top: 50px;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .sidebar.closed {
            transform: translateX(-100%);
        }
        .sidebar .menu {
            list-style: none;
            padding: 0;
        }
        .sidebar .menu li {
            margin: 20px 0;
        }
        .sidebar .menu li a {
            color: #d9d9d9;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .menu li a i {
            margin-right: 10px;
        }
        .sidebar .menu li a:hover {
            text-decoration: underline;
        }
        .sidebar .workspace {
            margin-top: 20px;
        }
        .sidebar .workspace .workspace-title {
            color: #d9d9d9;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .sidebar .workspace .workspace-item {
            margin: 10px 0;
        }
        .sidebar .workspace .workspace-item a {
            color: #d9d9d9;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .workspace .workspace-item a i {
            margin-right: 10px;
        }
        .sidebar .workspace .workspace-item a:hover {
            text-decoration: underline;
        }
        .sidebar .premium {
            margin-top: 20px;
            padding: 10px;
            background-color: #333;
            border-radius: 5px;
            text-align: center;
        }
        .sidebar .premium a {
            color: #d9d9d9;
            text-decoration: none;
        }
        .sidebar .premium a:hover {
            text-decoration: underline;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        .content.shifted {
            margin-left: 20px;
        }
        .content .section-title {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .content .templates {
            display: flex;
            flex-wrap: wrap;
        }
        .content .templates .template {
            background-color: #333;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            width: calc(25% - 20px);
            box-sizing: border-box;
            text-align: center;
        }
        .content .templates .template img {
            width: 100%;
            border-radius: 5px;
        }
        .content .templates .template .template-title {
            margin-top: 10px;
            font-size: 14px;
        }
        .content .templates .template .template-title span {
            background-color: #555;
            border-radius: 3px;
            padding: 2px 5px;
            font-size: 12px;
        }
        .content .templates .template .template-title span:hover {
            background-color: #777;
        }
        .content .templates .template .template-title a {
            color: #d9d9d9;
            text-decoration: none;
        }
        .content .templates .template .template-title a:hover {
            text-decoration: underline;
        }
        .content .jira {
            margin-top: 20px;
        }
        .content .jira .jira-title {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .content .jira .jira-templates {
            display: flex;
            flex-wrap: wrap;
        }
        .content .jira .jira-templates .jira-template {
            background-color: #333;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            width: calc(25% - 20px);
            box-sizing: border-box;
            text-align: center;
        }
        .content .jira .jira-templates .jira-template img {
            width: 100%;
            border-radius: 5px;
        }
        .content .jira .jira-templates .jira-template .jira-template-title {
            margin-top: 10px;
            font-size: 14px;
        }
        .content .jira .jira-templates .jira-template .jira-template-title a {
            color: #d9d9d9;
            text-decoration: none;
        }
        .content .jira .jira-templates .jira-template .jira-template-title a:hover {
            text-decoration: underline;
        }
        .create-board-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .create-board-modal .modal-content {
            background-color: #1c1c1c;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .create-board-modal .modal-content input {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: none;
            border-radius: 3px;
        }
        .create-board-modal .modal-content button {
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            background-color: #0079bf;
            color: #fff;
            cursor: pointer;
        }
        .create-board-modal .modal-content button:hover {
            background-color: #005a8c;
        }
        .toggle-sidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #1c1c1c;
            color: #d9d9d9;
            border: none;
            border-radius: 3px;
            padding: 10px;
            cursor: pointer;
            z-index: 1000;
        }
        .toggle-sidebar:hover {
            background-color: #333;
        }
  </style>
 </head>
 <body>
  <button class="toggle-sidebar" onclick="toggleSidebar()">

  </button>
  <div class="header">
   <div class="logo">
    <img alt="Trello Logo" height="24" src="https://storage.googleapis.com/a1aa/image/L8kl6lIPed2kOSNhw4I1MgPHKogwlOyMTQaT2iWCgM1AsekTA.jpg" width="24"/>
    <span>
     Trello
    </span>
   </div>
   <div class="nav">
    <a href="#">
     Workspaces
    </a>
    <a href="#">
     Recent
    </a>
    <a href="#">
     Starred
    </a>
    <a href="#">
     Templates
    </a>
    <button onclick="openCreateBoardModal()">
     Create
    </button>
   </div>
   <div class="search">
    <input placeholder="Search" type="text"/>
    <i class="fas fa-search">
    </i>
   </div>
  </div>
  <div class="sidebar" id="sidebar">
   <ul class="menu">
    <li>
     <a href="#">
      <i class="fas fa-columns">
      </i>
      Boards
     </a>
    </li>
    <li>
     <a href="#">
      <i class="fas fa-th-large">
      </i>
      Templates
     </a>
    </li>
    <li>
     <a href="#">
      <i class="fas fa-home">
      </i>
      Home
     </a>
    </li>
   </ul>
   <div class="workspace">
    <div class="workspace-title">
     Workspaces
    </div>
    <div class="workspace-item">
     <a href="#">
      <i class="fas fa-users">
      </i>
      Trello Workspace
     </a>
    </div>
    <ul class="menu">
     <li>
      <a href="#">
       <i class="fas fa-columns">
       </i>
       Boards
      </a>
     </li>
     <li>
      <a href="#">
       <i class="fas fa-heart">
       </i>
       Highlights
      </a>
     </li>
     <li>
      <a href="#">
       <i class="fas fa-eye">
       </i>
       Views
      </a>
     </li>
     <li>
      <a href="#">
       <i class="fas fa-user">
       </i>
       Members
      </a>
     </li>
     <li>
      <a href="#">
       <i class="fas fa-cog">
       </i>
       Settings
      </a>
     </li>
    </ul>
   </div>
   <div class="premium">
    <p>
     Try Trello Premium
    </p>
    <p>
     Get unlimited boards, all the views, unlimited automation, and more.
    </p>
    <a href="#">
     Start free trial
    </a>
   </div>
  </div>
  <div class="content" id="content">
   <div class="section-title">
    Most popular templates
   </div>
   <div class="templates">
    <div class="template">
     <img alt="Basic Board Template" height="100" src="https://storage.googleapis.com/a1aa/image/YsYdwugLxOqfZaaihb7ArxS7mYUPX5SXIX4Y9zO4SUXfX9kTA.jpg" width="200"/>
     <div class="template-title">
      <span>
       Template
      </span>
      <a href="#">
       Basic Board
      </a>
     </div>
    </div>
    <div class="template">
     <img alt="Kanban Template" height="100" src="https://storage.googleapis.com/a1aa/image/c9v3W24apOZKNBMB4LHJ2INyJfbvvcSnPgPVum2UTjdBsekTA.jpg" width="200"/>
     <div class="template-title">
      <span>
       Template
      </span>
      <a href="#">
       Kanban Template
      </a>
     </div>
    </div>
    <div class="template">
     <img alt="Daily Task Management Template" height="100" src="https://storage.googleapis.com/a1aa/image/lZ9iOYCe4fhKdEuvDYleZYCX9NerUKepUggfkh3offLDJY9kTA.jpg" width="200"/>
     <div class="template-title">
      <span>
       Template
      </span>
      <a href="#">
       Daily Task Management...
      </a>
     </div>
    </div>
    <div class="template">
     <img alt="Remote Team Hub Template" height="100" src="https://storage.googleapis.com/a1aa/image/s4tcYuOOVPJVH57T0luRvfoqvUfLql7ftElI5mw88mRBw6JnA.jpg" width="200"/>
     <div class="template-title">
      <span>
       Template
      </span>
      <a href="#">
       Remote Team Hub
      </a>
     </div>
    </div>
   </div>
   <div class="jira">
    <div class="jira-title">
     Jira
    </div>
    <div class="jira-templates">
     <div class="jira-template">
      <img alt="Project Management Template" height="100" src="https://storage.googleapis.com/a1aa/image/wpZL4JMGzWIiMtfAAQIHMderBeSFBzteKuGOjfwgi18DBrncC.jpg" width="200"/>
      <div class="jira-template-title">
       <a href="#">
        Project Management
       </a>
      </div>
     </div>
     <div class="jira-template">
      <img alt="Scrum Template" height="100" src="https://storage.googleapis.com/a1aa/image/aafRlceUfBOFPoJiUveEwvPKAJ3EwC8SNW3YmYLgxnAWg1TOB.jpg" width="200"/>
      <div class="jira-template-title">
       <a href="#">
        Scrum
       </a>
      </div>
     </div>
     <div class="jira-template">
      <img alt="Bug Tracking Template" height="100" src="https://storage.googleapis.com/a1aa/image/2xpfY0rpwmzOQahIOhNAj3adez54B8lM4MCeGtm23mWJw6JnA.jpg" width="200"/>
      <div class="jira-template-title">
       <a href="#">
        Bug Tracking
       </a>
      </div>
     </div>
     <div class="jira-template">
      <img alt="Web Design Process Template" height="100" src="https://storage.googleapis.com/a1aa/image/zcVlOud0URKlIFvFRQYQbvyW6U14XvgC2sqh7gi9KwfDsekTA.jpg" width="200"/>
      <div class="jira-template-title">
       <a href="#">
        Web Design Process
       </a>
      </div>
     </div>
    </div>
   </div>
  </div>
  <div class="create-board-modal" id="createBoardModal">
   <div class="modal-content">
    <h2>
     Create New Board
    </h2>
    <input id="boardTitle" placeholder="Enter board title" type="text"/>
    <button onclick="createBoard()">
     Create
    </button>
   </div>
  </div>
  <script>
   function openCreateBoardModal() {
            document.getElementById('createBoardModal').style.display = 'flex';
        }

        function createBoard() {
            var boardTitle = document.getElementById('boardTitle').value;
            if (boardTitle) {
                var newBoard = document.createElement('div');
                newBoard.className = 'template';
                newBoard.innerHTML = `
                    <img src="https://placehold.co/200x100" alt="New Board Image" />
                    <div class="template-title">
                        <span>Template</span>
                        <a href="#">${boardTitle}</a>
                    </div>
                `;
                document.querySelector('.templates').appendChild(newBoard);
                document.getElementById('createBoardModal').style.display = 'none';
                document.getElementById('boardTitle').value = '';
            } else {
                alert('Please enter a board title');
            }
        }

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            sidebar.classList.toggle('closed');
            content.classList.toggle('shifted');
        }
  </script>
 </body>
</html>
