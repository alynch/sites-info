Repo to test demo site to keep track of applications.

The dashboard displays the list of sites and relevant information:

- the URL for the production site
- the current status
- the IP address
- software details extracted from the HTTP response headers


- The information is stored in a cache database
- We use Server-sent Events (SSE) for the server to return information about the potentially slow responses


We use this application as a playground to investigate new technologies.

- SVG for timeline

- SSE for application status

- CSS grid and flexbox

- Laravel cache

- Scheduling for status info

- Vue.js

- localStorage

- Feature and Unit tests

- Get info about applications from Gitlab
