CREATE TABLE IF NOT EXISTS log_levels (
    log_level_id INTEGER PRIMARY KEY,
    log_level_name VARCHAR(10) NOT NULL
);

INSERT INTO log_levels (log_level_id, log_level_name) VALUES
    (0, 'INFO'),
    (1, 'CRITICAL'),
    (2, 'WARNING');

CREATE TABLE IF NOT EXISTS logs (
    log_id INTEGER PRIMARY KEY AUTOINCREMENT,
    log_level_id INTEGER NOT NULL DEFAULT 0,
    log_source VARCHAR NOT NULL, -- This will be a unix path '/path/to/script'
    log_message TEXT NOT NULl,
    log_entry_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (log_level_id) REFERENCES log_levels(log_level_id)
);


CREATE VIEW IF NOT EXISTS log_statistics AS
    SELECT levels.log_level_name, COUNT(logs.log_id) FROM logs
    JOIN log_levels levels ON log_levels.log_level_id = logs.log_level_id
    GROUP BY logs.log_level_id;

CREATE VIEW IF NOT EXISTS log_statistics_last_7_days AS
    SELECT log_levels.log_level_name, COUNT(logs.log_id) as count FROM logs
    JOIN log_levels ON log_levels.log_level_id = logs.log_level_id 
    WHERE logs.log_entry_timestamp > DATETIME(CURRENT_TIMESTAMP, '-7 day')
    GROUP BY logs.log_level_id;


CREATE TABLE IF NOT EXISTS job_history (
    job_id INTEGER PRIMARY KEY AUTOINCREMENT,
    job_source TEXT NOT NULL, -- This will be the path to the script
    job_result VARCHAR(7) NOT NULL, -- will be N/A, Fail or Success
    job_exit_code INTEGER NOT NULL,
    job_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE VIEW IF NOT EXISTS last_ten_failed_jobs AS
    SELECT  job_timestamp, job_source, job_exit_code FROM job_history
    WHERE job_result = "Fail"
    ORDER BY job_timestamp DESC
    LIMIT 10;

CREATE TABLE IF NOT EXISTS crontabs (
    crontab_id INTEGER PRIMARY KEY AUTOINCREMENT,
    crontab_path VARCHAR NOT NULL UNIQUE, -- this will be the parent directory of the crontab file
    crontab_created_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    crontab_modified_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    crontab_data BLOB NOT NULL
);