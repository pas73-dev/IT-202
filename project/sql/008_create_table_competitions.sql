CREATE TABLE `Competitions`
(
    id int auto_increment, //added all of these inorder for the create competition page to work
    name varchar(30) not null,
    created timestamp default CURRENT_TIMESTAMP,
    duration int default 3,
    expires timestamp,
    reward int,
    cost int default 1,
    participants int default 0,
    paid_out tinyint default 0,
    min_score int default 1,
    first_place_per float default 1,
    second_place_per float default 0.0,
    third_place_per float default 0.0,
    fee int default 0,
    user_id int,
    primary key (id),
    foreign key (user_id) references Users(id)
)
