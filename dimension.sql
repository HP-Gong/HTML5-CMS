CREATE TABLE `posts` (
  `p_id` int(15) NOT NULL auto_increment,
  `ptitle` text NOT NULL,
  `photos` text NOT NULL,
  `contents` text NOT NULL,
  `status` text NOT NULL,
  `date` timestamp NOT NULL,
   PRIMARY KEY (p_id) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`p_id`, `ptitle`, `photos`, `contents`, `status`, `date`) VALUES (1, 'Intro', 'pic02.jpg', 'Aenean ornare velit lacus, ac varius enim ullamcorper eu. Proin aliquam facilisis ante interdum congue. Integer mollis, nisl amet convallis, porttitor magna ullamcorper, amet egestas mauris. Ut magna finibus nisi nec lacinia. Nam maximus erat id euismod egestas. By the way, check out my <a href="#work">awesome work</a>. <br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum. Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat maximus. Pellentesque aliquam maximus risus, vel sed vehicula.', 'publish', '2017-07-04 07:30:29');

INSERT INTO `posts` (`p_id`, `ptitle`, `photos`, `contents`, `status`, `date`) VALUES (2, 'Work', 'pic03.jpg', 'Adipiscing magna sed dolor elit. Praesent eleifend dignissim arcu, at eleifend sapien imperdiet ac. Aliquam erat volutpat. Praesent urna nisi, fringila lorem et vehicula lacinia quam. Integer sollicitudin mauris nec lorem luctus ultrices. <br />Nullam et orci eu lorem consequat tincidunt vivamus et sagittis libero. Mauris aliquet magna magna sed nunc rhoncus pharetra. Pellentesque condimentum sem. In efficitur ligula tate urna. Maecenas laoreet massa vel lacinia pellentesque lorem ipsum dolor. Nullam et orci eu lorem consequat tincidunt. Vivamus et sagittis libero. Mauris aliquet magna magna sed nunc rhoncus amet feugiat tempus.', 'publish', '2017-07-04 09:28:02');

INSERT INTO `posts` (`p_id`, `ptitle`, `photos`, `contents`, `status`, `date`) VALUES (3, 'About', 'pic01.jpg', 'Lorem ipsum dolor sit amet, consectetur et adipiscing elit. Praesent eleifend dignissim arcu, at eleifend sapien imperdiet ac. Aliquam erat volutpat. Praesent urna nisi, fringila lorem et vehicula lacinia quam. Integer sollicitudin mauris nec lorem luctus ultrices. Aliquam libero et malesuada fames ac ante ipsum primis in faucibus. Cras viverra ligula sit amet ex mollis mattis lorem ipsum dolor sit amet.', 'publish', '2017-07-04 10:15:48');

INSERT INTO `posts` (`p_id`, `ptitle`, `photos`, `contents`, `status`, `date`) VALUES (4, 'Misc 1', 'pic02.jpg','Aenean ornare velit lacus, ac varius enim ullamcorper eu. Proin aliquam facilisis ante interdum congue. Integer mollis, nisl amet convallis, porttitor magna ullamcorper, amet egestas mauris. Ut magna finibus nisi nec lacinia. Nam maximus erat id euismod egestas.', 'publish', '2017-07-04 11:48:39');

CREATE TABLE `content` (
  `c_id` int(15) NOT NULL auto_increment,
  `mtitle` text NOT NULL,
  `logo_icons` text NOT NULL,
  `ctitle` text NOT NULL,
  `info` text NOT NULL,
  `footer` text NOT NULL,
   PRIMARY KEY (c_id) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `content` (`c_id`, `mtitle`, `logo_icons`, `ctitle`, `info`, `footer`) VALUES
(1, 'Dimension by HTML5 UP', 'icon fa-diamond', 'Dimension', 'A fully responsive site template designed by <a href="https://html5up.net">HTML5 UP</a> and released<br />for free under the <a href="https://html5up.net/license">Creative Commons</a> license.', '&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>');

CREATE TABLE `social` (
  `s_id` int(15) NOT NULL auto_increment,
  `stitle` text NOT NULL,
  `icons` text NOT NULL,
  `links` text NOT NULL,
  `status` text NOT NULL,
   PRIMARY KEY (s_id) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `social` (`s_id`, `stitle`, `icons`, `links`, `status`) VALUES (1, 'Twitter', 'icon fa-twitter', '#', 'publish');
INSERT INTO `social` (`s_id`, `stitle`, `icons`, `links`, `status`) VALUES (2, 'Facebook', 'icon fa-facebook', '#', 'publish');
INSERT INTO `social` (`s_id`, `stitle`, `icons`, `links`, `status`) VALUES (3, 'Instagram', 'icon fa-instagram', '#', 'publish');
INSERT INTO `social` (`s_id`, `stitle`, `icons`, `links`, `status`) VALUES (4, 'GitHub', 'icon fa-github', '#', 'publish');

CREATE TABLE `myadmin` (
  `u_id` int(15) NOT NULL auto_increment,
  `myname` text NOT NULL,
  `uname` text NOT NULL,
  `upassword` text NOT NULL,
  `date` timestamp NOT NULL,
   PRIMARY KEY (u_id) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `myadmin` (`u_id`, `myname`, `uname`, `upassword`, `date`) VALUES (1, 'Somebody', 'anyname', '123456789', '2017-07-05 23:09:27');
