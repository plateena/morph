# Use Node.js LTS Alpine as base image
FROM node:lts-alpine

# Set working directory
WORKDIR /usr/src/app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the app source code
COPY . .

# Expose port 8080
EXPOSE 8080

# Command to run the Vue.js app
# CMD ["npm", "run", "serve"]
