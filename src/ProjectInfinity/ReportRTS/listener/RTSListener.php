<?php

namespace ProjectInfinity\ReportRTS\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\event\player\PlayerQuitEvent;
use ProjectInfinity\ReportRTS\ReportRTS;
use ProjectInfinity\ReportRTS\util\PermissionHandler;

class RTSListener implements Listener {

    private $plugin;

    public function __construct(ReportRTS $plugin) {
        $this->plugin = $plugin;
        /* Setup permission handler so that there is a centralized class doing all the magic for permissions checkups.
        Much easier to maintain when changing nodes. */
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        if(count($this->plugin->notifications) > 0) {
            # TODO: Do something because there are pending notifications!
        }

        # Check if player is staff and add to array if true.
        if($event->getPlayer()->hasPermission(PermissionHandler::isStaff)) {
            array_push($this->plugin->staff, $event->getPlayer()->getName());
            array_unique($this->plugin->staff);
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event) {
        # TODO: This needs testing, if it works then remove this comment.
        if(($staff = array_search($event->getPlayer()->getName(), $this->plugin->staff)) !== false) {
            unset($$this->plugin->staff[$staff]);
        }
    }

}