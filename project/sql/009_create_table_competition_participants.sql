CREATE TABLE `Association`
(
    id      int auto_increment,
    user_id int,
    comp_id  int,
    created TIMESTAMP default current_timestamp,
    primary key (id),
    foreign key (user_id) references Users (id),
    foreign key (comp_id) references Competitions(id)
)
