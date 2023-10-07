FROM node:20.0.0-alpine

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm config set update-notifier false

RUN npm run build

EXPOSE 3000

CMD ["node", "build"]