FROM node:20.0.0-alpine

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

RUN npm config set update-notifier false

EXPOSE 3000

CMD ["node", "build"]