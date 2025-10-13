package main_test

import (
	"testing"

	"github.com/typisttech/php-matrix/internal"
)

//go:generate go run ./main.go
func Test(t *testing.T) {
	internal.RunTestscript(t)
}
