# Use official Node.js LTS version as the base image
FROM node:lts-alpine AS build

# Set the working directory in the container
WORKDIR /var/www/vue

# Copy package.json and package-lock.json from the src directory to the working directory
COPY ./src/package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY ./src .

# Build the Vue.js application
RUN npm run build

# Copy entrypoint script into the container
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Make entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["tail", "-f", "/dev/null"]
