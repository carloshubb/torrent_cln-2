<?php

class TestAssertion extends Exception {}

function assert_equals($expected, $actual, $message = null)
{
    if ($expected !== $actual) {
        throw new TestAssertion(
            $message ?: sprintf(
                'Failed to assert that %s is equal to %s',
                json_encode($expected),
                json_encode($actual)
            )
        );
    }
}

function assert_true($actual, $message = null)
{
    assert_equals(true, $actual, $message);
}

function assert_false($actual, $message = null)
{
    assert_equals(false, $actual, $message);
}

function assert_null($actual, $message = null)
{
    assert_equals(null, $actual, $message);
}

function assert_exception(\Closure $callback, $exceptionClass, $exceptionMessage = null, $message = null)
{
    $message = $message ?: sprintf('Failed to assert that the expected exception %s is thrown', $exceptionClass);

    try {
        $callback();
    } catch (Exception $e) {
        assert_equals($exceptionClass, get_class($e), $message);

        if ($exceptionMessage) {
            assert_equals($exceptionMessage, $e->getMessage(), $message);
        }
    } catch (Throwable $e) {
        assert_equals($exceptionClass, get_class($e), $message);

        if ($exceptionMessage) {
            assert_equals($exceptionMessage, $e->getMessage(), $message);
        }
    }
}
