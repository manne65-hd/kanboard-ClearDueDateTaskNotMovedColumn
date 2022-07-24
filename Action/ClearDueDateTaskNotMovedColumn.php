<?php

namespace Kanboard\Plugin\ClearDueDateTaskNotMovedColumn\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Action\Base;

/**
 * Clear due-date automatically in a defined column after a certain amount of time
 *
 */
class ClearDueDateTaskNotMovedColumn extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Clear the due date of a task in a specific column when not moved during a given period');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(TaskModel::EVENT_DAILY_CRONJOB);
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'duration' => t('Duration in hours'),
            'column_id' => t('Column')
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array('tasks');
    }

    /**
     * Execute the action (clear due-date)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $results = array();
        $max = $this->getParam('duration') * 3600;

        foreach ($data['tasks'] as $task) {
            $duration = time() - $task['date_moved'];

            if ($duration > $max && $task['column_id'] == $this->getParam('column_id')) {
              $values = array(
                  'id'       => $task['id'],
                  'date_due' => 0,
              );
              $results[] = $this->taskModificationModel->update($values, false);            }
        }

        return in_array(true, $results, true);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return count($data['tasks']) > 0;
    }
}
