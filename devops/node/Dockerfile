FROM node:22-alpine

RUN apk add --no-cache \
    curl \
    git \
    vim \
    tree

WORKDIR /usr/src/theme

# Keep the container alive
CMD ["tail", "-f", "/dev/null"]