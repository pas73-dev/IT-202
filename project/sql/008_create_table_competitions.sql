CREATE TABLE IF NOT EXISTS `Competitions`
(
    id int auto_increment,
    name varchar(60) not null,
    created TIMESTAMP default current_timestamp,
    duration int default 3,
    expires timestamp,
    reward int default 0,
    cost int default 1,
    participants int default 0,
    paid_out tinyint default 0,
    min_score int default 0,
    first_place_per float default 1,
    second_place_per float default 0.0,
    third_place_per float default 0.0,
    fee int default 0,
    primary key (id),
    foreign key (user_id) references Users(id)
)
