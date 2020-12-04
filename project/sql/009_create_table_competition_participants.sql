CREATE TABLE IF NOT EXISTS `Association`
(
    id      int auto_increment,
    user_id int,
    comp_id  int,
    `created` timestamp default current_timestamp,
    `modified`   timestamp default current_timestamp on update current_timestamp,
    primary key (id),
    foreign key (user_id) references Users (id),
    foreign key (comp_id) references Competitions(id),
    unique key `user_comp` (user_id, comp_id)
)
