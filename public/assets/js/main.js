document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    if (window.isLoggedIn) {
        fetchUserProjects();
    } else {
        fetchPublicProjects();
    }
});

function setupEventListeners() {
    if (window.isLoggedIn) {
        document.getElementById('logoutBtn').addEventListener('click', logout);
        document.getElementById('newProjectBtn').addEventListener('click', () => showModal('newProjectModal'));
        document.getElementById('closeNewProjectModal').addEventListener('click', () => hideModal('newProjectModal'));
        document.getElementById('createProjectBtn').addEventListener('click', createProject);
        document.getElementById('closeNewTaskModal').addEventListener('click', () => hideModal('newTaskModal'));
        document.getElementById('createTaskBtn').addEventListener('click', createTask);
    } else {
        document.getElementById('loginBtn').addEventListener('click', () => window.location.href = 'views/login.php');
        document.getElementById('registerBtn').addEventListener('click', () => window.location.href = 'views/register.php');
    }
}

async function fetchUserProjects() {
    try {
        const response = await fetch('index.php?action=getUserProjects');
        const data = await response.json();
        if (data.success) {
            renderProjects(data.projects);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching projects.');
    }
}

async function fetchPublicProjects() {
    try {
        const response = await fetch('index.php?action=getPublicProjects');
        const data = await response.json();
        if (data.success) {
            renderProjects(data.projects);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching public projects.');
    }
}

function renderProjects(projects) {
    const projectContainer = document.getElementById('projectContainer');
    projectContainer.innerHTML = '';
    
    projects.forEach(project => {
        const projectElement = createProjectElement(project);
        projectContainer.appendChild(projectElement);
    });
}

function createProjectElement(project) {
    const projectElement = document.createElement('div');
    projectElement.className = 'bg-gray-800 rounded-lg shadow-md p-4';
    projectElement.innerHTML = `
        <h2 class="text-lg font-semibold mb-4">${project.name}</h2>
        <p class="text-sm text-gray-400 mb-4">${project.description}</p>
        <div class="flex justify-between items-center">
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200">
                ${project.is_public ? 'Public' : 'Private'}
            </span>
            ${window.isLoggedIn ? `
                <button class="viewTasksBtn px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50" data-project-id="${project.id}">
                    View Tasks
                </button>
            ` : ''}
        </div>
    `;

    if (window.isLoggedIn) {
        const viewTasksBtn = projectElement.querySelector('.viewTasksBtn');
        if (viewTasksBtn) {
            viewTasksBtn.addEventListener('click', () => fetchTasks(project.id));
        }
    }

    return projectElement;
}

async function fetchTasks(projectId) {
    try {
        const response = await fetch(`index.php?action=getProjectTasks&project_id=${projectId}`);
        const data = await response.json();
        if (data.success) {
            renderTasks(data.tasks, projectId);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching tasks.');
    }
}

function renderTasks(tasks, projectId) {
    const projectElement = document.querySelector(`[data-project-id="${projectId}"]`).closest('.bg-gray-800');
    const tasksContainer = document.createElement('div');
    tasksContainer.className = 'mt-4 space-y-2';
    
    tasks.forEach(task => {
        const taskElement = createTaskElement(task);
        tasksContainer.appendChild(taskElement);
    });

    const addTaskBtn = document.createElement('button');
    addTaskBtn.className = 'mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50';
    addTaskBtn.textContent = 'Add Task';
    addTaskBtn.addEventListener('click', () => showNewTaskModal(projectId));

    projectElement.appendChild(tasksContainer);
    projectElement.appendChild(addTaskBtn);
}

function createTaskElement(task) {
    const taskElement = document.createElement('div');
    taskElement.className = 'bg-gray-700 rounded-lg p-3';
    taskElement.innerHTML = `
        <h3 class="font-medium">${task.title}</h3>
        <p class="text-sm text-gray-400">${task.description}</p>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-${getStatusColor(task.status)}-600 bg-${getStatusColor(task.status)}-200">
                ${task.status}
            </span>
            <button class="updateStatusBtn px-2 py-1 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50" data-task-id="${task.id}">
                Update Status
            </button>
        </div>
    `;

    taskElement.querySelector('.updateStatusBtn').addEventListener('click', () => showUpdateStatusModal(task));

    return taskElement;
}

function getStatusColor(status) {
    switch (status.toLowerCase()) {
        case 'todo': return 'blue';
        case 'doing': return 'yellow';
        case 'review': return 'purple';
        case 'done': return 'green';
        default: return 'gray';
    }
}

function showModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function hideModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function showNewTaskModal(projectId) {
    document.getElementById('newTaskProjectId').value = projectId;
    showModal('newTaskModal');
}

function showUpdateStatusModal(task) {
    // Implement the update status modal
    alert('Update status functionality not implemented yet.');
}

async function createProject() {
    const name = document.getElementById('newProjectName').value;
    const description = document.getElementById('newProjectDescription').value;
    const isPublic = document.getElementById('newProjectIsPublic').checked;

    try {
        const response = await fetch('index.php?action=createProject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, description, is_public: isPublic }),
        });
        const data = await response.json();
        if (data.success) {
            hideModal('newProjectModal');
            fetchUserProjects();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating the project.');
    }
}

async function createTask() {
    const projectId = document.getElementById('newTaskProjectId').value;
    const title = document.getElementById('newTaskTitle').value;
    const description = document.getElementById('newTaskDescription').value;
    const status = document.getElementById('newTaskStatus').value;

    try {
        const response = await fetch('index.php?action=createTask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ project_id: projectId, title, description, status }),
        });
        const data = await response.json();
        if (data.success) {
            hideModal('newTaskModal');
            fetchTasks(projectId);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating the task.');
    }
}

async function logout() {
    try {
        const response = await fetch('index.php?action=logout', {
            method: 'POST'
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = '../index.php';
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while logging out.');
    }
}

