<?php

interface ILeaderLandingRewardDao
{
    public function getLeaderLandingRewards($leaderLanding);

    public function insertLeaderLandingRewards($leaderLanding);

    public function updateLeaderLanding($leaderLanding);

    public function fillLandingRewardById($landingReward);
}
