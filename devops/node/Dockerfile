# Use an official Node.js image as a base
FROM node:22-alpine

# Install necessary dependencies including zsh, git, and util-linux (for chsh)
RUN apk add --no-cache \
    curl \
    zsh \
    git \
    vim \
    tree

# Install Oh My Zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

# Set the working directory inside the container
WORKDIR /usr/src/theme

# Keep the container alive
CMD ["tail", "-f", "/dev/null"]