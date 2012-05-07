<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/inbox.css">
<script type='text/javascript' src='/assets/javascript/jquery.bbq.js'></script>
<script type="text/javascript" src="/assets/javascript/jquery.timeago.js"></script>
<script type='text/javascript' src='/assets/javascript/inbox.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
    <!--Sidebar content-->
    <ul id="filterTabs" class="nav nav-pills nav-stacked">
        <li class="nav-header"><h4>Your Messages</h4></li>
        <li class="active"><a>Inbox</a></li>
        <li><a>Unread</a></li>
    </ul>
    </div>

    <div id="content" class="span10">
      <!--Body content-->
        <ul id="messageTabs" class="nav nav-tabs">
          <li class="active" data-id="0"><a onclick="return Twexter.inbox.load(0);">Inbox</a></li>
        </ul>
        <div id="inboxContent">
          <div style="text-align: center;">
            <img src="/assets/images/loading.gif"><br /><br />
            Loading your mailbox. Please wait...
          </div>
        </div>
    </div>
  </div>
</div> <!--class="container-fluid"-->
