CREATE TABLE authors (
  id INTEGER GENERATED ALWAYS AS IDENTITY NOT NULL PRIMARY KEY,
  author varchar(255) NOT NULL
);

INSERT INTO authors (id, author) OVERRIDING SYSTEM VALUE VALUES
(1, 'Dr. Seuss'),
(2, 'Jack Sparrow'),
(3, 'Bruce Lee'),
(4, 'Julius Caesar'),
(5, 'George Santayana'),
(6, 'John W. Gardner'),
(7, 'Neil Armstrong'),
(8, 'Neil deGrasse Tyson'),
(9, 'Elon Musk'),
(10, 'Arthur C. Clarke');

ALTER SEQUENCE authors_id_seq
RESTART WITH 11;


CREATE TABLE categories (
  id INTEGER GENERATED ALWAYS AS IDENTITY NOT NULL PRIMARY KEY,
  category varchar(255) NOT NULL
);

INSERT INTO categories (id, category) OVERRIDING SYSTEM VALUE VALUES
(1, 'Funny'),
(2, 'Philosophical'),
(3, 'Life'),
(4, 'History'),
(5, 'Space');

ALTER SEQUENCE categories_id_seq
RESTART WITH 6;


CREATE TABLE quotes (
  id INTEGER GENERATED ALWAYS AS IDENTITY NOT NULL PRIMARY KEY,
  quote varchar(255) NOT NULL,
  author_id INT NOT NULL,
  category_id INT NOT NULL
);

INSERT INTO quotes (id, quote, author_id, category_id) OVERRIDING SYSTEM VALUE VALUES
(1, 'Today you are you! That is truer than true! There is no one alive who is you-er than you!', 1, 1),
(2, 'The problem is not the problem. The problem is your attitude about the problem.', 2, 2),
(3, 'I meant what I said and I said what I meant.', 1, 1),
(4, 'You make''m, I amuse''em.', 1, 1),
(5, 'The more that you read, the more things you will know. The more that you learn, the more places you''ll go.', 1, 2),
(6, 'I like nonsense; it wakes up the brain cells.', 1, 1),
(7, 'I fear not the man who has practiced 10,000 kicks once, but I fear the man who has practiced one kick 10,000 times.', 3, 3),
(8, 'There is no weapon more deadly than the will.', 3, 3),
(9, 'A quick temper will make a fool of you soon enough.', 3, 1),
(10, 'Showing off is the fool''s idea of glory.', 3, 1),
(11, 'As you think, so shall you become.', 3, 2),
(12, 'This is the day you will always remember as the day you almost caught Captain Jack Sparrow.', 2, 1),
(13, 'I''m dishonest, and a dishonest man you can always trust to be dishonest. Honestly. It''s the honest ones you want to watch out for, because you can never predict when they''re going to do something incredibly … stupid.', 2, 3),
(14, 'Why fight when you can negotiate?', 2, 3),
(15, 'Not all treasure is silver and gold, mate.', 2, 3),
(16, 'I came, I saw, I conquered.', 4, 4),
(17, 'Experience is the teacher of all things.', 4, 3),
(18, 'Those who do not remember the past are condemned to repeat it.', 5, 4),
(19, 'History never looks like history when you are living through it.', 6, 4),
(20, 'That''s one small step for a man, one giant leap for mankind.', 7, 5),
(21, 'The Universe is under no obligation to make sense to you.', 8, 5),
(22, 'I would like to die on Mars. Just not on impact.', 9, 5),
(23, 'Two possibilities exist: either we are alone in the Universe or we are not. Both are equally terrifying.', 10, 5),
(24, 'Even with all our technology and the inventions that make modern life so much easier than it once was, it takes just one big natural disaster to wipe all that away and remind us that, here on Earth, we''re still at the mercy of nature.', 8, 3),
(25, 'Rockets are cool. There''s no getting around that.', 9, 5);
(26, 'There is no cure for birth and death save to enjoy the interval.', 5, 4)

ALTER SEQUENCE quotes_id_seq
RESTART WITH 27;


