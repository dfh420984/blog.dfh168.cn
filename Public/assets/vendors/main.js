var nav_bar = {
    template: '<nav class="navbar">\n' +
        '      <button class="btn btn-default navbar-btn fa fa-bars"></button>\n' +
        '      <ul class="nav navbar-nav navbar-right">\n' +
        '        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>\n' +
        '        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>\n' +
        '      </ul>\n' +
        '    </nav>'
};

var head_image = {
    template:'<div class="profile">\n' +
        '        <img class="avatar" src="../uploads/avatar.jpg">\n' +
        '        <h3 class="name">布头儿</h3>\n' +
        '      </div>'
}

var aside_temple = {
    template:'<ul class="nav">\n' +
        '      <li>\n' +
        '      <a href="index.html"><i class="fa fa-dashboard"></i>仪表盘</a>\n' +
        '      </li>\n' +
        '      <li class="active">\n' +
        '      <a href="#menu-posts" data-toggle="collapse">\n' +
        '      <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>\n' +
        '      </a>\n' +
        '      <ul id="menu-posts" class="collapse in">\n' +
        '      <li class="active"><a href="posts.html">所有文章</a></li>\n' +
        '      <li><a href="post-add.html">写文章</a></li>\n' +
        '      <li><a href="categories.html">分类目录</a></li>\n' +
        '      </ul>\n' +
        '      </li>\n' +
        '      <li>\n' +
        '      <a href="comments.html"><i class="fa fa-comments"></i>评论</a>\n' +
        '      </li>\n' +
        '      <li>\n' +
        '      <a href="users.html"><i class="fa fa-users"></i>用户</a>\n' +
        '      </li>\n' +
        '      <li>\n' +
        '      <a href="#menu-settings" class="collapsed" data-toggle="collapse">\n' +
        '      <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>\n' +
        '      </a>\n' +
        '      <ul id="menu-settings" class="collapse">\n' +
        '      <li><a href="nav-menus.html">导航菜单</a></li>\n' +
        '      <li><a href="slides.html">图片轮播</a></li>\n' +
        '      <li><a href="settings.html">网站设置</a></li>\n' +
        '      </ul>\n' +
        '      </li>\n' +
        '      </ul>'
}

Vue.component('nav_bar',nav_bar);
Vue.component('head_image',head_image);
Vue.component('aside_temple',aside_temple);