<?php


include('../components/FriendLanding/FriendLandingManager.php');
include('../model/FriendLanding.php');
include('../model/LeaderDeal.php');

$FriendLandingManager = new FriendLandingManager();

$deal = new LeaderDeal();

$FriendLanding = new FriendLanding();

$FriendLanding->slogan = "A";
$FriendLanding->friendMessage = "D";
$FriendLanding->rewardMessage1 = "B";
$FriendLanding->rewardMessage2 ="c";


$FriendLandingManager->showFriendLanding($FriendLanding,$deal);
