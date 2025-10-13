package internal_test

import (
	"os/exec"
	"testing"
)

func Test(t *testing.T) {
	p, err := exec.LookPath("php-matrix")
	if err != nil {
		t.Error("Could not find php-matrix binary in PATH")
		t.FailNow()
	}

	t.Logf("Found php-matrix binary at %s", p)
}
