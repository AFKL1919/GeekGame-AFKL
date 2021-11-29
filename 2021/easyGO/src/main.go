package main

import (
	"SYC/geek/route"

	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func main() {
	webapp := gin.Default()
	store := cookie.NewStore([]byte("[I AM NOT GONNA TELL YOU]"))

	webapp.Use(sessions.Sessions("PHPSESSION", store))
	webapp.Use(gin.Recovery())

	webapp.Static("/static", "./")

	route.SetRoute(webapp)

	// After executing `go build` in the current directory, AFKL puts the file that was just compiled into the /app folder.
	webapp.Run(":8080")
}
