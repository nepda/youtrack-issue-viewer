YouTrack Issue Viewer
=

A simple and clean YouTrack issue viewer based on [`nepda/youtrack-client`](https://github.com/nepda/youtrack-client).

**Caution! You will make all issues publicly available if you expose this tool to the public!** There is no login
here. Use at your own risk.

```
    git clone https://github.com/nepda/youtrack-issue-viewer.git
    cd youtrack-issue-viewer
    cp .config.php.dist .config.php
    # vim .config.php #edit config file to your needs 
    php -S localhost:8080 -t public/
```

You can access any issue with the URL http://localhost:8080/SBX-1234 where `SBX-1234` is the issue id.

![Screenshot](https://raw.githubusercontent.com/nepda/youtrack-issue-viewer/master/screenshot.png)
