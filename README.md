## Recommended Configuration for Laravel Cloud Background Process
* Connection - database - You already set this in .env, so keep it the same here.
* Queue - Command - queue:work - Correct — this runs your queued jobs continuously.
* --backoff - 5 - (seconds) How long to wait before retrying a failed job.
* --sleep - 2	(seconds) - How long to wait if there are no new jobs. Keeps CPU usage low.
* --rest -(leave empty) - Optional — rarely used. You can skip it.
* --timeout - 60	(seconds) - How long to allow each job to run before it’s killed. 60s is safe for mail jobs.
* --tries - 3 (times) - Number of times to retry a failed job before marking it failed.
* --force	- Turn it ON - This forces the worker to run even in production mode. Always enable it in deployment environments.

