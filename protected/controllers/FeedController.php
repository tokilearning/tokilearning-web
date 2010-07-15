<?php

/**
 *
 */
class FeedController extends CController {

    public $layout = 'application.views.layouts.feed';
    public $defaultAction = 'announcements';

    public function actionAnnouncements() {
        Yii::import('application.vendors.*');
        require_once('rssgen/rss_generator.inc.php');
        $announcements = Announcement::model()->published()->findAll(array('limit' => 10));

        $rss_channel = new rssGenerator_channel();
        $rss_channel->atomLinkHref = '';
        $rss_channel->title = 'TOKI Learning Center';
        $rss_channel->link = 'http://lc.toki.if.itb.ac.id';
        $rss_channel->description = 'Berita terbaru tentang TOKI Learning Center.';
        $rss_channel->language = 'id-ID';
        $rss_channel->generator = 'PHP RSS Feed Generator';
        $rss_channel->managingEditor = 'petra.barus@gmail.com (Petra Barus)';
        $rss_channel->webMaster = 'petra.barus@gmail.com (Petra Barus)';
        $rss_channel->image->url = Yii::app()->request->baseUrl.'/images/logo-toki-158.png';
        $rss_channel->image->title = 'TOKI Learning Center';
        $rss_channel->image->link = $this->createAbsoluteUrl('/');

        foreach ($announcements as $announcement) {
            //var_dump($announcement);
            $item = new rssGenerator_item();
            $item->title = $announcement->title;
            //echo $announcement->content;
			$content = strip_tags($announcement->content);
			$content = (strlen($content) > 400) ? substr($content, 0, 400)."..." : $content;
            $item->description = $content;
            $item->link = $this->createAbsoluteUrl('/announcement/view', array('id' => $announcement->id));
            $item->guid = $this->createAbsoluteUrl('/announcement/view', array('id' => $announcement->id));
            $item->author = $announcement->author->full_name;
            //$item->link = 'http://newsite.com';
            //$item->guid = 'http://newsite.com';
            $item->pubDate = date('r', strtotime($announcement->created_date ));
            //$item->pubDate = 'Tue, 07 Mar 2006 00:00:01 GMT';
            $rss_channel->items[] = $item;
        }

        $rss_feed = new rssGenerator_rss();
        $rss_feed->encoding = 'UTF-8';
        $rss_feed->version = '2.0';
        header('Content-Type: text/xml');
        echo $rss_feed->createFeed($rss_channel);
    }
    
}
