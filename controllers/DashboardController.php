<?php
class DashboardController {
    private $user;
    private $task;
    
    public function __construct() {
        $this->user = new User();
        $this->task = new Task();
    }
    
    public function personalDashboard() {
        $userId = $_SESSION['user_id'];
        
        // Get user's tasks statistics
        $taskStats = $this->task->getUserTaskStats($userId);
        
        // Get user's recent activities
        $recentActivities = $this->task->getUserRecentActivities($userId);
        
        // Get upcoming deadlines
        $upcomingDeadlines = $this->task->getUpcomingDeadlines($userId);
        
        // Get project participation
        $projectParticipation = $this->user->getProjectParticipation($userId);
        
        require_once 'views/user/dashboard.php';
    }
    
    public function projectManagerDashboard() {
        if ($_SESSION['role'] !== 'PROJECT_MANAGER') {
            header('Location: /dashboard.php');
            exit;
        }
        
        // Get overall project statistics
        $projectStats = $this->project->getOverallStats();
        
        // Get team performance metrics
        $teamPerformance = $this->user->getTeamPerformance();
        
        // Get project deadlines
        $projectDeadlines = $this->project->getAllDeadlines();
        
        require_once 'views/admin/dashboard.php';
    }
}

