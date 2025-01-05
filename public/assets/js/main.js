document.addEventListener('DOMContentLoaded', () => {
    fetchProjects();
});

async function fetchProjects() {
    try {
        const response = await fetch('/index.php?action=getUserProjects', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        if (data.success) {
            renderProjects(data.projects);
        } else {
            console.error('Failed to fetch projects:', data.message);
            showError('Failed to load projects. Please try again later.');
        }
    } catch (error) {
        // console.error('Error fetching projects:', error);
        showError('An error occurred while loading projects. Please try again later.');
    }
}

function renderProjects(projects) {
    const projectList = document.querySelector('main');
    projectList.innerHTML = '';
    projects.forEach(project => {
        const projectElement = createProjectElement(project);
        projectList.appendChild(projectElement);
    });
}

function createProjectElement(project) {
    const projectElement = document.createElement('section');
    projectElement.className = 'bg-gray-800 rounded-lg shadow-md p-4';
    projectElement.innerHTML = `
        <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
            <span>${project.name}</span>
        </h2>
        <p class="text-gray-300 mb-4">${project.description}</p>
        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="viewProject(${project.id})">View Tasks</button>
    `;
    return projectElement;
}

async function viewProject(projectId) {
    try {
        const response = await fetch(`index.php?action=getProjectTasks&project_id=${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        if (data.success) {
            renderTasks(data.tasks);
        } else {
            console.error('Failed to fetch tasks:', data.message);
            showError('Failed to load tasks. Please try again later.');
        }
    } catch (error) {
        console.error('Error fetching tasks:', error);
        showError('An error occurred while loading tasks. Please try again later.');
    }
}

function renderTasks(tasks) {
    const main = document.querySelector('main');
    main.innerHTML = '';
    const columns = ['TODO', 'DOING', 'REVIEW', 'DONE'];
    
    columns.forEach((status, index) => {
        const column = document.createElement('section');
        column.className = 'bg-gray-800 rounded-lg shadow-md p-4';
        column.innerHTML = `
            <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                <span>${status}</span>
                <span class="text-sm font-normal bg-${getStatusColor(status)}-900 text-${getStatusColor(status)}-300 py-1 px-3 rounded-full">${tasks.filter(task => task.status === status).length}</span>
            </h2>
            <div class="space-y-4" id="${status.toLowerCase()}-tasks"></div>
        `;
        main.appendChild(column);
    });

    tasks.forEach(task => {
        const taskElement = createTaskElement(task);
        document.getElementById(`${task.status.toLowerCase()}-tasks`).appendChild(taskElement);
    });
}

function createTaskElement(task) {
    const taskElement = document.createElement('div');
    taskElement.className = 'bg-gray-700 border border-gray-600 rounded-lg p-4 shadow-sm';
    taskElement.innerHTML = `
        <div class="flex justify-between items-start mb-2">
            <span class="px-2 py-1 text-xs font-semibold bg-${getPriorityColor(task.priority)}-900 text-${getPriorityColor(task.priority)}-300 rounded-full">${task.priority}</span>
            <button class="text-gray-400 hover:text-gray-200" onclick="showTaskOptions(${task.id})">
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

function getPriorityColor(priority) {
    switch (priority) {
        case 'HIGH':
            return 'red';
        case 'MEDIUM':
            return 'yellow';
        case 'LOW':
            return 'green';
        default:
            return 'blue';
    }
}

function getStatusColor(status) {
    switch (status) {
        case 'TODO':
            return 'blue';
        case 'DOING':
            return 'yellow';
        case 'REVIEW':
            return 'purple';
        case 'DONE':
            return 'green';
        default:
            return 'gray';
    }
}

function showTaskOptions(taskId) {
    console.log('Show options for task:', taskId);
    // Implement task options (e.g., edit, delete, change status)
}

function showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'bg-red-500 text-white p-4 rounded-md mb-4';
    errorElement.textContent = message;
    document.querySelector('main').prepend(errorElement);
    setTimeout(() => errorElement.remove(), 5000);
}