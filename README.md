
News-3: Demonstration of modules inheritance
============================================

Basic (ancestor) module-package is news_2b_161124, which inherited module-package news_1b_160430.

New feature(s) in version news_3b_171202:
- tags submodule

You can set parent module news_1b_160430 instead of news_2b_161124
and lost functionality from news_2b_161124 (news backup/restore and slugs for URLs).
For this you have to modify such files:
- Module.php
- config/routes-admin.php, routes-main.php
- controllers/AdminController.php, MainController.php
