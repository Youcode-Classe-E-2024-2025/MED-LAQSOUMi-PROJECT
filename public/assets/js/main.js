document.addEventListener('DOMContentLoaded', () => {
    fetchProjects();
});

async function fetchProjects() {
    try {
        const response = await fetch('/api/user/projects');
        const data = await response.json();
        if (data.success) {
            renderProjects(data.projects);
        } else {
            console.error('Failed to fetch projects:', data.message);
        }
    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}

function renderProjects(projects) {
    const projectList = document.getElementById('project-list');
    projectList.innerHTML = '';
    projects.forEach(project => {
        const projectElement = createProjectElement(project);
        projectList.appendChild(projectElement);
    });
}

function createProjectElement(project) {
    const projectElement = document.createElement('div');
    projectElement.className = 'bg-gray-700 rounded-lg p-4 shadow-sm';
    projectElement.innerHTML = `
        <h3 class="text-lg font-semibold mb-2">${project.name}</h3>
        <p class="text-gray-300 mb-4">${project.description}</p>
        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="viewProject(${project.id})">View Tasks</button>
    `;
    return projectElement;
}

async function viewProject(projectId) {
    try {
        const response = await fetch(`/api/projects/${projectId}/tasks`);
        const data = await response.json();
        if (data.success) {
            renderTasks(data.tasks);
        } else {
            console.error('Failed to fetch tasks:', data.message);
        }
    } catch (error) {
        console.error('Error fetching tasks:', error);
    }
}

function renderTasks(tasks) {
    const taskList = document.getElementById('task-list');
    taskList.innerHTML = '';
    const columns = {
        'TODO': document.querySelector('section:nth-child(1) .space-y-4'),
        'DOING': document.querySelector('section:nth-child(2) .space-y-4'),
        'REVIEW': document.querySelector('section:nth-child(3) .space-y-4'),
        'DONE': document.querySelector('section:nth-child(4) .space-y-4')
    };

    tasks.forEach(task => {
        const taskElement = createTaskElement(task);
        columns[task.status].appendChild(taskElement);
    });

    document.getElementById('projects').classList.add('hidden');
    document.getElementById('tasks').classList.remove('hidden');
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

function showTaskOptions(taskId) {
    console.log('Show options for task:', taskId);
}