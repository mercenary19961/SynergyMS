<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectRequestNotification extends Notification
{
    use Queueable;

    protected $project;

    public function __construct(Project $project)   
    {
        $this->project = $project;
    }

    // Specify the channels to use for notifications (only 'database')
    public function via($notifiable)
    {
        return ['database'];
    }

    // Create the data to store in the database notification
    public function toArray($notifiable)
    {
        return [
            'type' => 'App\Notifications\ProjectRequestNotification',
            'project_id' => $this->project->id,
            'name' => $this->project->name,
            'department' => $this->project->department->name,
            'message' => 'A new project request has been submitted.',
        ];
    }
}
