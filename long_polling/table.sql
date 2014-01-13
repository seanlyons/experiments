USE seandb;
CREATE TABLE `long_poll_command_queue` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
    `client_sid` varchar(12) NOT NULL, /* can be a single client sid or 'all'. */
    `function` varchar(255) NOT NULL,
    `args` varchar(255) NOT NULL,
    `acknowledged` tinyint(1) NOT NULL,
    PRIMARY KEY `client_sid` (`client_sid`),
    KEY (`id`)
) ENGINE=InnoDB;