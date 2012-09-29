<?php

interface ILeaderLandingDao
{
    public function getLeaderLandings($campaign);

    public function insertLeaderLanding($campaign, $leaderLanding);

    public function updateLeaderLanding($leaderLanding);

}
