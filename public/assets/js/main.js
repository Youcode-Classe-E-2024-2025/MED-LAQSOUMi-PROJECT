document.addEventListener('DOMContentLoaded', () => {
    fetchProjects();
    setupEventListeners();
});

function setupEventListeners() {
    document.getElementById('logoutBtn').addEventListener('click', logout);
    document.getElementById('newProjectBtn').addEventListener('click', () => showModal('newProjectModal'));
    document.getElementById('closeNewProjectModal').addEventListener('click', () => hideModal('newProjectModal'));
    document.getElementById('createProjectBtn').addEventListener('click', createProject);
    document.getElementById('closeNewTaskModal').addEventListener('click', () => hideModal('newTaskModal'));
    document.getElementById('createTaskBtn').addEventListener('click', createTask);
}

async function fetchProjects() {
    try {
        const response = await fetch('index?action=getUserProjects');
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

function renderProjects(projects) {
    const projectContainer = document.getElementById('projectContainer');
    projectContainer.innerHTML = '';
    
    const columns = ['TODO', 'DOING', 'REVIEW', 'DONE'];
    
    columns.forEach(column => {
        const columnElement = document.createElement('section');
        columnElement.className = 'bg-gray-800 rounded-lg shadow-md p-4';
        columnElement.innerHTML = `
            <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                <span>${column}</span>
                <span class="text-sm font-normal bg-${getColumnColor(column)}-900 text-${getColumnColor(column)}-300 py-1 px-3 rounded-full">0</span>
            </h2>
            <div id="${column.toLowerCase()}-tasks" class="space-y-4">
                <!-- Tasks will be dynamically inserted here -->
            </div>
        `;
        projectContainer.appendChild(columnElement);
    });

    projects.forEach(project => {
        fetchTasks(project.id);
    });
}

function getColumnColor(column) {
    switch (column) {
        case 'TODO': return 'blue';
        case 'DOING': return 'yellow';
        case 'REVIEW': return 'purple';
        case 'DONE': return 'green';
        default: return 'gray';
    }
}

async function fetchTasks(projectId) {
    try {
        const response = await fetch(`index?action=getProjectTasks&project_id=${projectId}`);
        const data = await response.json();
        if (data.success) {
            renderTasks(data.tasks);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching tasks.');
    }
}

function renderTasks(tasks) {
    tasks.forEach(task => {
        const taskElement = createTaskElement(task);
        const columnElement = document.getElementById(`${task.status.toLowerCase()}-tasks`);
        columnElement.appendChild(taskElement);
        updateColumnCount(task.status);
    });
}

function createTaskElement(task) {
    const taskElement = document.createElement('div');
    taskElement.className = 'bg-gray-700 border border-gray-600 rounded-lg p-4 shadow-sm';
    taskElement.innerHTML = `
        <div class="flex justify-between items-start mb-2">
            <span class="px-2 py-1 text-xs font-semibold bg-${getColumnColor(task.status)}-900 text-${getColumnColor(task.status)}-300 rounded-full">${task.status}</span>
            <button class="text-gray-400 hover:text-gray-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
            </button>
        </div>
        <h3 class="font-medium mb-2">${task.title}</h3>
        <p class="text-sm text-gray-400 mb-2">${task.description}</p>
        <div class="flex items-center text-sm text-gray-400">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            <span>${new Date(task.created_at).toLocaleDateString()}</span>
        </div>
    `;
    return taskElement;
}

function updateColumnCount(status) {
    const columnElement = document.querySelector(`h2:has(span:first-child:contains('${status}'))`);
    const countElement = columnElement.querySelector('span:last-child');
    const currentCount = parseInt(countElement.textContent);
    countElement.textContent = currentCount + 1;
}

function showModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function hideModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

async function createProject() {
    const name = document.getElementById('newProjectName').value;
    const description = document.getElementById('newProjectDescription').value;

    try {
        const response = await fetch('index?action=createProject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, description }),
        });
        const data = await response.json();
        if (data.success) {
            hideModal('newProjectModal');
            fetchProjects();
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
        const response = await fetch('index?action=createTask', {
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
        const response = await fetch('index?action=logout');
        const data = await response.json();
        if (data.success) {
            window.location.href = './login.php';
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while logging out.');
    }
}

